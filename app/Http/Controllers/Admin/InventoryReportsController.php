<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderProduct;
use App\Models\StockHistory;
use Carbon\Carbon;


class InventoryReportsController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        $ldate = date('M j , Y');

        $products    = Product::latest()->get();

        foreach($products as $product){

            //PREVIOS DATE
            $sales_inventory_prev = OrderProduct::where('product_code', $product->code)
                ->whereBetween('created_at', ['2001-01-01', Carbon::today()])->sum('qty');

            $delivery_inventory_prev = StockHistory::where('product_code', $product->code)
                ->whereBetween('created_at', ['2001-01-01', Carbon::today()])->sum('stock_expi');

            //CURRENT DATE
            $beginning_inventory = $delivery_inventory_prev - $sales_inventory_prev;


            $sales_inventory = OrderProduct::where('product_code', $product->code)->whereDate('created_at', Carbon::today())->sum('qty');
            $delivery_inventory = StockHistory::where('product_code', $product->code)->whereDate('created_at', Carbon::today())->sum('stock_expi');

            $ending_inventory = $beginning_inventory + $delivery_inventory - $sales_inventory;

            $productss[] = array(
                'code'              => $product->code,
                'description'          => $product->description,
                'category'             => $product->category->name,
                'sales_inventory'  => $sales_inventory,
                'delivery_inventory'  => $delivery_inventory,
                'beginning_inventory'  => $beginning_inventory,
                'ending_inventory'     => $ending_inventory,
            );



        }
        return view('admin.inventory_reports', compact('productss', 'categories','ldate'));
    }
}
