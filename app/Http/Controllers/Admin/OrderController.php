<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderProduct;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailNotification;
use App\Models\Category;
use App\Models\Forcast;
use League\Flysystem\Plugin\ForcedCopy;

class OrderController extends Controller
{


    public function trend_projection($category)
    {
        // Sample data
        $dataFocast = array(
          2021 =>  (float)OrderProduct::where('category',$category)->whereYear('created_at', '=', '2021')->whereMonth('created_at', '=', 1)->sum('qty'),
          2022 => (float)OrderProduct::where('category',$category)->whereYear('created_at', '=', '2022')->whereMonth('created_at', '=', 1)->sum('qty'),
          2023 =>  (float)OrderProduct::where('category',$category)->whereYear('created_at', '=', '2023')->whereMonth('created_at', '=', 1)->sum('qty'),
        );


        // Calculate the mean of X and Y values
        $x_mean = array_sum(array_keys($dataFocast)) / count($dataFocast);
        $y_mean = array_sum(array_values($dataFocast)) / count($dataFocast);

        // Calculate the covariance and variance of X and Y
        $covariance = 0;
        $variance = 0;

        foreach ($dataFocast as $x => $y) {
            $covariance += ($x - $x_mean) * ($y - $y_mean);
            $variance += ($x - $x_mean) * ($x - $x_mean);
        }

        // Calculate the slope and intercept of the trend line
        $slope = $covariance / $variance;
        $intercept = $y_mean - ($slope * $x_mean);

        return function ($x) use ($slope, $intercept) {
            // Generate forecast for period X
            return $slope * $x + $intercept;
        };
    }

    public function forcast(){
       return dd($this->trend_projection("BEVERAGES")(2024));
    }



    public function orders()
    {
            $orders = Order::latest()->get();
            return view('admin.orders' ,compact('orders'));

    }

    public function receipt(Order $order){
        return view('admin.receipt' ,compact('order'));
    }


    public function status(Order $order, Request $request){
        $type = $request->get('type');
        $emailNotif = [
            'msg'              => "SUCCESSFULLY APPROVED YOUR ORDERS",
            'name'              =>  $order->user->name,
            'address'              =>  $order->user->address,
            'contact_number'              =>  $order->user->contact_number,
            'email'              =>  $order->user->email,
            'delivery'  => "Date Delivered " . date('M j , Y h:i A'),
            'order_number'     => $order->id,
            'placed_on'         =>  $order->created_at->format('M j , Y h:i A') ,
            'total' => number_format($order->orderproducts->sum('amount')),
        ];

        if($type == 'PAID')
        {
            if($order->payment_status == 'ON PROCESS'){
                Order::find($order->id)->update([
                    'payment_status'    => 'PAID',
                ]);
            }

            if($order->payment_status == 'PAID'){
                Order::find($order->id)->update([
                    'payment_status'    => 'DECLINED',
                ]);
            }

            if($order->payment_status == 'DECLINED'){
                Order::find($order->id)->update([
                    'payment_status'    => 'ON PROCESS',
                ]);
            }
        }else{
            if($order->status == "PENDING"){
                Order::find($order->id)->update([
                    'status'    => 'APPROVED',
                ]);
                $order->orderproducts()->update([
                    'status'    => 'APPROVED',
                ]);
                Mail::to($order->user->email)
                    ->send(new EmailNotification($emailNotif));



            }

            if($order->status == "APPROVED"){
                Order::find($order->id)->update([
                    'status'    => 'PENDING',
                ]);
                $order->orderproducts()->update([
                    'status'    => 'PENDING',
                ]);
            }

        }

        return response()->json(['success' => 'Updated Successfully.']);

    }

    public function sales_reports($filter, $from , $to){

        $userrole = auth()->user()->role;

        if($filter == 'daily'){
            $title_filter  = 'From: ' . date('F d, Y') . ' To: ' . date('F d, Y');
            $sales = OrderProduct::latest()->whereDate('created_at', Carbon::today())
                                ->get();


        }
        elseif($filter == 'weekly'){
            $title_filter  = 'From: ' . Carbon::now()->startOfWeek()->format('F d, Y') . ' To: ' . Carbon::now()->endOfWeek()->format('F d, Y');
            $sales = OrderProduct::latest()->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                    ->get();

            $chartSales  = OrderProduct::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                ->selectRaw('sum(amount) as total_sales, DATE(created_at) as data, sum(amount) + sum(price)  as total_predict')
                                ->groupBy('data')
                                ->get();


        }
        elseif($filter == 'monthly'){
            $title_filter  = 'From: ' . date('F '. 1 .', Y') . ' To: ' . date('F '. 31 .', Y');
            $sales = OrderProduct::latest()->whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'))
                                    ->get();
            $chartSales  = OrderProduct::selectRaw("sum(amount) as total_sales, DATE_FORMAT(created_at, '%m-%Y') as data, sum(amount) + sum(price)  as total_predict")
                        ->groupBy('data')
                        ->get();
        }
        elseif($filter == 'yearly'){
            $title_filter  = 'From: ' .'Jan 1'. date(', Y') . ' To: ' .'Dec 31'. date(', Y');
            $sales = OrderProduct::latest()->whereYear('created_at', '=', date('Y'))
                                    ->get();
            $chartSales  = OrderProduct::selectRaw("sum(amount) as total_sales, DATE_FORMAT(created_at, '%Y') as data, sum(amount) + sum(price)  as total_predict")
                                    ->groupBy('data')
                                    ->get();
        }
        elseif($filter == 'all'){
            $title_filter  = 'ALL RECORDS';
            $sales = OrderProduct::latest()->get();
            $chartSales  = OrderProduct::selectRaw('sum(amount) as total_sales, DATE(created_at) as data, sum(amount) + sum(price)  as total_predict')
                                    ->groupBy('data')
                                    ->get();
        }
        elseif($filter == 'fbd'){
            $title_filter  =  'From: '.date('F d, Y', strtotime($from)). ' To: ' .date('F d, Y', strtotime($to));
            $sales = OrderProduct::latest()->whereBetween('created_at', [$from, $to])->get();
            $chartSales  = OrderProduct::whereBetween('created_at', [$from, $to])
                                    ->selectRaw('sum(amount) as total_sales, DATE(created_at) as data, sum(amount) + sum(price)  as total_predict')
                                    ->groupBy('data')
                                    ->get();
        }
        elseif($filter == 'setup'){
            $forcasts = Forcast::all();
            $categories = Category::orderBy('name')->get();
            return view('admin.sales_reports.setup', compact('forcasts','categories'));
        }
        else{
            $title_filter  = 'From: ' . date('F d, Y') . ' To: ' . date('F d, Y');
            $sales = OrderProduct::latest()->whereDate('created_at', Carbon::today())
                                    ->get();
        }




        $ldate = date('M j , Y');
        $chart_filter  = 'From: ' .'Jan 1'. date(', Y') . ' To: ' .'Dec 31'. date(', Y');

        //YEAR DROPDOWN
        $years_dropdown  = OrderProduct::selectRaw('YEAR(created_at) as year')
                            ->orderBy('year')
                            ->groupBy('year')->get()->toArray();
        array_push($years_dropdown, [
           "year" => end($years_dropdown[count($years_dropdown) - 1]) + 1,
        ]);
        array_push($years_dropdown, [
            "year" => end($years_dropdown[count($years_dropdown) - 1]) + 1,
        ]);
        array_push($years_dropdown, [
        "year" => end($years_dropdown[count($years_dropdown) - 1]) + 1,
        ]);



        return view('admin.sales_reports.sales_reports', compact('years_dropdown','sales','title_filter','ldate','chart_filter'));

    }

    public function chart_reports($filter_date, Request $request){
        $filter = $request->get('filter');

        if($filter == 'daily'){
            $list = OrderProduct::whereDate('created_at', '=', $filter_date)->latest()->get();
        }
        elseif($filter == 'weekly'){
            $list = OrderProduct::whereDate('created_at', '=', $filter_date)->latest()->get();


        }
        elseif($filter == 'monthly'){
            $list = OrderProduct::whereMonth('created_at', '=', $filter_date)->latest()->get();
        }
        elseif($filter == 'yearly'){
            $list = OrderProduct::whereYear('created_at', '=', $filter_date)->latest()->get();

        }
        elseif($filter == 'all'){
            $list = OrderProduct::whereDate('created_at', '=', $filter_date)->latest()->get();

        }
        elseif($filter == 'fbd'){
            $list = OrderProduct::whereDate('created_at', '=', $filter_date)->latest()->get();

        }
        elseif($filter == 'modal_data'){
        $category = $request->get('category');
        $month = date("m", strtotime($request->get('month')));
        $year = $request->get('year');


        $list = OrderProduct::where('category', '=', $category)
                                ->whereMonth('created_at', '=', $month)
                                ->whereYear('created_at', '=', $year)
                                ->latest()->get();
        $sold = $list->sum('sold');
        }
        else{
            $list = OrderProduct::whereDate('created_at', '=', $filter_date)->latest()->get();

        }



        $sales = $list->sum('amount');
        if($filter == 'home'){
            $lm = OrderProduct::whereMonth(
                'created_at', '=', Carbon::now()->subMonth()->month
            )->get();
            $predic = $lm->sum('amount');
        }else{
            $predic = $list->sum('amount') + $list->sum('price');
        }

        return response()->json(
            [
                'result' => $list,
                'sold' => $sold,
                'sales' => $sales,
                'predic' => $predic,
                'filter' => $filter,
            ]
        );
    }

    public function chart_category($category, $m, $y, Request $request){
        $month = date("m", strtotime($m));
        $year = $y;
        $ldate = date('M j , Y');


        $sales = OrderProduct::where('category', '=', $category)
                                ->whereMonth('created_at', '=', $month)
                                ->whereYear('created_at', '=', $year)
                                ->latest()->get();
        $title_filter = "Category: " .$category ." Month/Year: ". $m ."/". $y;

        return view('admin.sales_reports.data_chart', compact('sales','ldate','title_filter'));
    }




}


