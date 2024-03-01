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
    public function index($date)
    {
        $categories = Category::latest()->get();


        $products    = Product::latest()->get();

        foreach ($products as $product) {

            if ($date == 'today') {
                $ldate = date('M j , Y');

                //PREVIOS DATE
                $sales_inventory_prev = OrderProduct::where('product_code', $product->code)
                    ->whereBetween('created_at', ['2001-01-01', Carbon::today()])->sum('qty');
                $delivery_inventory_prev = StockHistory::where('product_code', $product->code)
                    ->whereBetween('created_at', ['2001-01-01', Carbon::today()])->sum('stock_expi');
                $prev_bad_order = StockHistory::where('product_code', $product->code)
                    ->whereBetween('created_at', ['2001-01-01', Carbon::today()])->sum('bad_order');
                $prev_phy_add = StockHistory::where('product_code', $product->code)
                    ->whereBetween('created_at', ['2001-01-01', Carbon::today()])->sum('phy_add');
                $prev_phy_minus = StockHistory::where('product_code', $product->code)
                    ->whereBetween('created_at', ['2001-01-01', Carbon::today()])->sum('phy_minus');

                //CURRENT DATE
                $sales_inventory = OrderProduct::where('product_code', $product->code)->whereDate('created_at', Carbon::today())->sum('qty');
                $delivery_inventory = StockHistory::where('product_code', $product->code)->whereDate('created_at', Carbon::today())->sum('stock_expi');
                $bad_order = StockHistory::where('product_code', $product->code)->whereDate('created_at', Carbon::today())->sum('bad_order');

                $phy_add = StockHistory::where('product_code', $product->code)->whereDate('created_at', Carbon::today())->sum('phy_add');
                $phy_minus = StockHistory::where('product_code', $product->code)->whereDate('created_at', Carbon::today())->sum('phy_minus');
            } else {
                $ldate = $date;

                //PREVIOS DATE
                $sales_inventory_prev = OrderProduct::where('product_code', $product->code)
                    ->whereBetween('created_at', ['2001-01-01', $date])->sum('qty');
                $delivery_inventory_prev = StockHistory::where('product_code', $product->code)
                    ->whereBetween('created_at', ['2001-01-01', $date])->sum('stock_expi');
                $prev_bad_order = StockHistory::where('product_code', $product->code)
                    ->whereBetween('created_at', ['2001-01-01', $date])->sum('bad_order');
                $prev_phy_add = StockHistory::where('product_code', $product->code)
                    ->whereBetween('created_at', ['2001-01-01', $date])->sum('phy_add');
                $prev_phy_minus = StockHistory::where('product_code', $product->code)
                    ->whereBetween('created_at', ['2001-01-01', $date])->sum('phy_minus');

                //CURRENT DATE
                $sales_inventory = OrderProduct::where('product_code', $product->code)->whereDate('created_at', $date)->sum('qty');
                $delivery_inventory = StockHistory::where('product_code', $product->code)->whereDate('created_at', $date)->sum('stock_expi');
                $bad_order = StockHistory::where('product_code', $product->code)->whereDate('created_at', $date)->sum('bad_order');
                $phy_add = StockHistory::where('product_code', $product->code)->whereDate('created_at', $date)->sum('phy_add');
                $phy_minus = StockHistory::where('product_code', $product->code)->whereDate('created_at', $date)->sum('phy_minus');
            }

            $beg_less = $sales_inventory_prev + $prev_bad_order + $prev_phy_minus;
            $beginning_inventory = $delivery_inventory_prev + $prev_phy_add - $beg_less;
            $ending_inventory = $beginning_inventory + $delivery_inventory + $phy_add - $sales_inventory - $bad_order - $phy_minus;

            $productss[] = array(
                'code'              => $product->code,
                'description'          => $product->description,
                'category'             => $product->category->name,
                'beginning_inventory'  => $beginning_inventory,
                'sales_inventory'  => $sales_inventory,
                'delivery_inventory'  => $delivery_inventory,
                'bad_order'  => $bad_order,
                'phy_add'  => $phy_add,
                'phy_minus'  => $phy_minus,
                'ending_inventory'     => $ending_inventory,
                'created_at' => $product->created_at,
                'isModifyToday' => $beginning_inventory != $ending_inventory ? "isModify" : "notModify",
            );
        }
        //$productss = collect($productss)->where('isModifyToday', true)->toArray();
        $productss = collect($productss)->toArray();


        return view('admin.inventory_reports', compact('productss', 'categories', 'ldate'));
    }
}
