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

class OrderController extends Controller
{
    public function orders()
    {
        $userrole = auth()->user()->role;
        if($userrole != 'customer'){
            $orders = Order::latest()->get();
            return view('admin.orders' ,compact('orders'));
        }
        return abort('403');
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

            $chartSales  = OrderProduct::selectRaw('sum(amount) as total_sales, DATE(created_at) as data, sum(amount) + sum(price)  as total_predict')
                                ->groupBy('data')
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
        else{
            $title_filter  = 'From: ' . date('F d, Y') . ' To: ' . date('F d, Y');
            $sales = OrderProduct::latest()->whereDate('created_at', Carbon::today())
                                    ->get();
        }



        $labels = $chartSales->pluck('data')->toArray();
        $data = $chartSales->pluck('total_sales')->toArray();
        $datap = $chartSales->pluck('total_predict')->toArray();
        $ldate = date('M j , Y');



        return view('admin.sales_reports.sales_reports', compact('sales','title_filter','labels','data','datap','chartSales','ldate'));

    }

    public function chart_reports($filter_date, Request $request){
        $filter = $request->get('filter');

        if($filter == 'daily'){
            $list = OrderProduct::whereDate('created_at', '=', $filter_date)->get();
        }
        elseif($filter == 'weekly'){
            $list = OrderProduct::whereDate('created_at', '=', $filter_date)->get();


        }
        elseif($filter == 'monthly'){
            $list = OrderProduct::whereMonth('created_at', '=', $filter_date)->get();
        }
        elseif($filter == 'yearly'){
            $list = OrderProduct::whereYear('created_at', '=', $filter_date)->get();

        }
        elseif($filter == 'all'){
            $list = OrderProduct::whereDate('created_at', '=', $filter_date)->get();

        }
        elseif($filter == 'fbd'){
            $list = OrderProduct::whereDate('created_at', '=', $filter_date)->get();

        }
        elseif($filter == 'home'){
        $list = OrderProduct::where('product_code', '=', $filter_date)->get();

        }
        else{
            $list = OrderProduct::whereDate('created_at', '=', $filter_date)->get();

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
                'sales' => $sales,
                'predic' => $predic,
                'filter' => $filter,
            ]
        );
    }

}
