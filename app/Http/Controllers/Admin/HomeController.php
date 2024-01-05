<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;
use Carbon\Carbon;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $ldate = date('M j , Y h:i A');

        $userrole = auth()->user()->role;

            $products = Product::latest()->get();
            $productsLowerStocks = Product::latest()->where('stock', '<', 11)->get();



            $productsExpiration = Product::where("expiration","<", Carbon::now()->addMonths(3))->get();
            $exp_label  = 'From: ' . date('F d, Y') . ' To: ' . Carbon::now()->addMonths(3)->format('F d, Y');

            $products_today = Product::whereDate('created_at', Carbon::today())->get();

            $sold = OrderProduct::sum('qty');
            $sold_today = OrderProduct::whereDate('created_at', Carbon::today())->sum('qty');

            $orders = OrderProduct::latest()->get();
            $orders_today = OrderProduct::whereDate('created_at', Carbon::today())->get();

            $sales = OrderProduct::sum('amount');
            $sales_today = OrderProduct::whereDate('created_at', Carbon::today())->sum('amount');


        $data = OrderProduct::select(
            \DB::raw("SUM(amount) as amount"),
            \DB::raw("SUM(qty) as sold"),
            \DB::raw("category as cat"))

            ->groupBy('cat')
            ->orderBy('cat', 'ASC')
            ->get();
        $result_sales = [];
        $result_sold = [];

        foreach($data as $row) {
            $result_sales['label'][] = $row->cat;
            $result_sales['data'][] =  $row->amount;
        }

        foreach($data as $row) {
            $result_sold['label'][] = $row->cat;
            $result_sold['data'][] =  $row->sold;
        }

        $sales_results = json_encode($result_sales);
        $sold_results = json_encode($result_sold);



        return view('admin.home', compact('productsExpiration','productsLowerStocks','products','products_today','sold','sold_today', 'orders','orders_today','sales','sales_today','sales_results','sold_results','ldate','exp_label'));

    }
}
