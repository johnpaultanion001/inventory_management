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

        $chartSales  = OrderProduct::selectRaw('sum(qty) as sold, sum(amount) as total_sales, DATE(created_at) as data, sum(amount) + sum(price)  as total_predict')
                            ->groupBy('data')->get();

        OrderProduct::whereMonth('created_at', '=', 1)->sum('qty');

        $montly_sold = [];
        $montly_sold2021 = [];
        $montly_sold2022 = [];
        $montly_sold2024 = [];

        $categories = Category::whereNotIn('name', ['OTHERS'])->orderBy('name')->get();
        foreach ($categories as $category) {
            //2023
            array_push($montly_sold, [
                   $jan2023 = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 1)->sum('qty'),
                   $feb2023 = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 2)->sum('qty'),
                   $mar2023 = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 3)->sum('qty'),
                   $apr2023 = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 4)->sum('qty'),
                   $may2023 = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 5)->sum('qty'),
                   $june2023 = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 6)->sum('qty'),
                   $july2023 = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 7)->sum('qty'),
                   $aug2023 = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 8)->sum('qty'),
                   $sept2023 = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 9)->sum('qty'),
                   $oct2023 = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 10)->sum('qty'),
                   $nov2023 = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 11)->sum('qty'),
                   $dec2023 = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 12)->sum('qty'),
                    $category->name,
            ]);
            //2021
            array_push($montly_sold2021, [
                $jan2021 = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', '2021')->whereMonth('created_at', '=', 1)->sum('qty'),
                $feb2021 = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', '2021')->whereMonth('created_at', '=', 2)->sum('qty'),
                $mar2021 = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', '2021')->whereMonth('created_at', '=', 3)->sum('qty'),
                $apr2021 = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', '2021')->whereMonth('created_at', '=', 4)->sum('qty'),
                $may2021 = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', '2021')->whereMonth('created_at', '=', 5)->sum('qty'),
                $june2021 = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', '2021')->whereMonth('created_at', '=', 6)->sum('qty'),
                $july2021 = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', '2021')->whereMonth('created_at', '=', 7)->sum('qty'),
                $aug2021 = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', '2021')->whereMonth('created_at', '=', 8)->sum('qty'),
                $sept2021 = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', '2021')->whereMonth('created_at', '=', 9)->sum('qty'),
                $oct2021 = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', '2021')->whereMonth('created_at', '=', 10)->sum('qty'),
                $nov2021 = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', '2021')->whereMonth('created_at', '=', 11)->sum('qty'),
                $dec2021 = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', '2021')->whereMonth('created_at', '=', 12)->sum('qty'),
                $category->name,
            ]);
            //2022
            array_push($montly_sold2022, [
                $jan2022 =  OrderProduct::where('category', $category->name)->whereYear('created_at', '=', '2022')->whereMonth('created_at', '=', 1)->sum('qty'),
                $feb2022 =  OrderProduct::where('category', $category->name)->whereYear('created_at', '=', '2022')->whereMonth('created_at', '=', 2)->sum('qty'),
                $mar2022 =  OrderProduct::where('category', $category->name)->whereYear('created_at', '=', '2022')->whereMonth('created_at', '=', 3)->sum('qty'),
                $apr2022 =  OrderProduct::where('category', $category->name)->whereYear('created_at', '=', '2022')->whereMonth('created_at', '=', 4)->sum('qty'),
                $may2022 =  OrderProduct::where('category', $category->name)->whereYear('created_at', '=', '2022')->whereMonth('created_at', '=', 5)->sum('qty'),
                $june2022 =  OrderProduct::where('category', $category->name)->whereYear('created_at', '=', '2022')->whereMonth('created_at', '=', 6)->sum('qty'),
                $july2022 =  OrderProduct::where('category', $category->name)->whereYear('created_at', '=', '2022')->whereMonth('created_at', '=', 7)->sum('qty'),
                $aug2022 =  OrderProduct::where('category', $category->name)->whereYear('created_at', '=', '2022')->whereMonth('created_at', '=', 8)->sum('qty'),
                $sept2022 =  OrderProduct::where('category', $category->name)->whereYear('created_at', '=', '2022')->whereMonth('created_at', '=', 9)->sum('qty'),
                $oct2022 =  OrderProduct::where('category', $category->name)->whereYear('created_at', '=', '2022')->whereMonth('created_at', '=', 10)->sum('qty'),
                $nov2022 =  OrderProduct::where('category', $category->name)->whereYear('created_at', '=', '2022')->whereMonth('created_at', '=', 11)->sum('qty'),
                $dec2022 =  OrderProduct::where('category', $category->name)->whereYear('created_at', '=', '2022')->whereMonth('created_at', '=', 12)->sum('qty'),
                $category->name,
            ]);
            //2024
            // array_push($montly_sold2024, [
            //     ($jan2023 + $jan2021 + $jan2022) / 3,
            //     ($feb2023 + $feb2021 + $feb2022) / 3,
            //     ($mar2023 + $mar2021 + $mar2022) / 3,
            //     ($apr2023 + $apr2021 + $apr2022) / 3,
            //     ($may2023 + $may2021 + $may2022) / 3,
            //     ($june2023 + $june2021 + $june2022) / 3,
            //     ($july2023 + $july2021 + $july2022) / 3,
            //     ($aug2023 + $aug2021 + $aug2022) / 3,
            //     ($sept2023 + $sept2021 + $sept2022) / 3,
            //     ($oct2023 + $oct2021 + $oct2022) / 3,
            //     ($nov2023 + $nov2021 + $nov2022) / 3,
            //     ($dec2023 + $dec2021 + $dec2022) / 3,
            //     $category->name,
            // ]);

            array_push($montly_sold2024, [
                   $jan2024 = Forcast::where('category', $category->name)->where('month', '=', 1)->sum('total'),
                   $feb2024 = Forcast::where('category', $category->name)->where('month', '=', 2)->sum('total'),
                   $mar2024 = Forcast::where('category', $category->name)->where('month', '=', 3)->sum('total'),
                   $apr2024 = Forcast::where('category', $category->name)->where('month', '=', 4)->sum('total'),
                   $may2024 = Forcast::where('category', $category->name)->where('month', '=', 5)->sum('total'),
                   $june2024 = Forcast::where('category', $category->name)->where('month', '=', 6)->sum('total'),
                   $july2024 = Forcast::where('category', $category->name)->where('month', '=', 7)->sum('total'),
                   $aug2024 = Forcast::where('category', $category->name)->where('month', '=', 8)->sum('total'),
                   $sept2024 = Forcast::where('category', $category->name)->where('month', '=', 9)->sum('total'),
                   $oct2024 = Forcast::where('category', $category->name)->where('month', '=', 10)->sum('total'),
                   $nov2024 = Forcast::where('category', $category->name)->where('month', '=', 11)->sum('total'),
                   $dec2024 = Forcast::where('category', $category->name)->where('month', '=', 12)->sum('total'),
                   $category->name,
            ]);
        }
        //2023
        array_push($montly_sold, [
                $jan2023 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 1)->sum('qty'),
                $feb2023 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 2)->sum('qty'),
                $mar2023 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 3)->sum('qty'),
                $apr2023 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 4)->sum('qty'),
                $may2023 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 5)->sum('qty'),
               $june2023 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 6)->sum('qty'),
               $july2023 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 7)->sum('qty'),
                $aug2023 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 8)->sum('qty'),
               $sept2023 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 9)->sum('qty'),
                $oct2023 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 10)->sum('qty'),
                $nov2023 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 11)->sum('qty'),
                $dec2023 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 12)->sum('qty'),
                'others',
        ]);
        //2021
        array_push($montly_sold2021, [
            $jan2021 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=','2021')->whereMonth('created_at', '=', 1)->sum('qty'),
            $feb2021 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=','2021')->whereMonth('created_at', '=', 2)->sum('qty'),
            $mar2021 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=','2021')->whereMonth('created_at', '=', 3)->sum('qty'),
            $apr2021 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=','2021')->whereMonth('created_at', '=', 4)->sum('qty'),
            $may2021 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=','2021')->whereMonth('created_at', '=', 5)->sum('qty'),
           $june2021 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=','2021')->whereMonth('created_at', '=', 6)->sum('qty'),
           $july2021 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=','2021')->whereMonth('created_at', '=', 7)->sum('qty'),
            $aug2021 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=','2021')->whereMonth('created_at', '=', 8)->sum('qty'),
           $sept2021 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=','2021')->whereMonth('created_at', '=', 9)->sum('qty'),
            $oct2021 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=','2021')->whereMonth('created_at', '=', 10)->sum('qty'),
            $nov2021 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=','2021')->whereMonth('created_at', '=', 11)->sum('qty'),
            $dec2021 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=','2021')->whereMonth('created_at', '=', 12)->sum('qty'),
            'others',
        ]);
        //2022
        array_push($montly_sold2022, [
            $jan2022 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=','2022')->whereMonth('created_at', '=', 1)->sum('qty'),
            $feb2022 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=','2022')->whereMonth('created_at', '=', 2)->sum('qty'),
            $mar2022 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=','2022')->whereMonth('created_at', '=', 3)->sum('qty'),
            $apr2022 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=','2022')->whereMonth('created_at', '=', 4)->sum('qty'),
            $may2022 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=','2022')->whereMonth('created_at', '=', 5)->sum('qty'),
           $june2022 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=','2022')->whereMonth('created_at', '=', 6)->sum('qty'),
           $july2022 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=','2022')->whereMonth('created_at', '=', 7)->sum('qty'),
            $aug2022 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=','2022')->whereMonth('created_at', '=', 8)->sum('qty'),
           $sept2022 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=','2022')->whereMonth('created_at', '=', 9)->sum('qty'),
            $oct2022 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=','2022')->whereMonth('created_at', '=', 10)->sum('qty'),
            $nov2022 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=','2022')->whereMonth('created_at', '=', 11)->sum('qty'),
            $dec2022 =  OrderProduct::whereNotIn('category',['BEVERAGES','CANNED FOODS','FOOD AREA','CONDIMENTS','PERSONAL CARE','SOAP AREA'])->whereYear('created_at', '=','2022')->whereMonth('created_at', '=', 12)->sum('qty'),
            'others',
        ]);
        array_push($montly_sold2024, [
            $jan2024 = Forcast::where('category', 'OTHERS')->where('month', '=', 1)->sum('total'),
            $feb2024 = Forcast::where('category', 'OTHERS')->where('month', '=', 2)->sum('total'),
            $mar2024 = Forcast::where('category', 'OTHERS')->where('month', '=', 3)->sum('total'),
            $apr2024 = Forcast::where('category', 'OTHERS')->where('month', '=', 4)->sum('total'),
            $may2024 = Forcast::where('category', 'OTHERS')->where('month', '=', 5)->sum('total'),
            $june2024 = Forcast::where('category', 'OTHERS')->where('month', '=', 6)->sum('total'),
            $july2024 = Forcast::where('category', 'OTHERS')->where('month', '=', 7)->sum('total'),
            $aug2024 = Forcast::where('category', 'OTHERS')->where('month', '=', 8)->sum('total'),
            $sept2024 = Forcast::where('category', 'OTHERS')->where('month', '=', 9)->sum('total'),
            $oct2024 = Forcast::where('category', 'OTHERS')->where('month', '=', 10)->sum('total'),
            $nov2024 = Forcast::where('category', 'OTHERS')->where('month', '=', 11)->sum('total'),
            $dec2024 = Forcast::where('category', 'OTHERS')->where('month', '=', 12)->sum('total'),
            'OTHERS',
     ]);


    $chart_filter  = 'From: ' .'Jan 1'. date(', Y') . ' To: ' .'Dec 31'. date(', Y');


        return view('admin.sales_reports.sales_reports', compact('sales','title_filter','ldate','montly_sold','chart_filter','montly_sold2021','montly_sold2022','montly_sold2024'));

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
