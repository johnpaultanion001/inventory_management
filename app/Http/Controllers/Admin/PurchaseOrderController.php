<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Delivery;
use App\Models\PurchaseOrder;
use App\Models\Category;
use App\Models\Activity;
use App\Models\StockHistory;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;

class PurchaseOrderController extends Controller
{
    public function index()
    {

        $products = Product::latest()->get();
        $categories = Category::latest()->get();
        $deliveries = Delivery::where('isConfirm', false)->latest()->get();

        return view('admin.purchase_order.purchase_order', compact('products', 'categories', 'deliveries'));
    }
    public function order(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $validated =  Validator::make($request->all(), [
            'unit_order' => ['required'],
            'qty_order' => ['required', 'integer', 'min:1'],
            'supplier' => ['required'],

            //'expiration_order' => ['required','date', 'after:today'],
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        }

        $product = Product::where('id', $request->input('product_id'))->first();
        $deliver_order = Delivery::where('product_code', $product->code)
            ->where('isConfirm', false)->first();
        $unit_price = $product->unit_price;

        if ($deliver_order != null) {
            $qty = $deliver_order->qty + $request->input('qty_order');
            $total = $product->unit_price * $qty;
            $deliver_order->update([
                'qty' => $qty,
                'total' => $total,
            ]);
        } else {
            $total = $product->unit_price * $request->input('qty_order');

            Delivery::create([
                'product_id' => $request->input('product_id'),
                'product_code' => $request->input('order_code'),
                'unit' => $request->input('unit_order'),
                'qty' => $request->input('qty_order'),
                'supplier' => $request->input('supplier'),

                'unit_price' => $unit_price,
                //'expiration' => $request->input('expiration_order'),
                'total' => $total,
            ]);
        }


        Activity::create([
            'activity' => 'Order product',
            'user_id' => Auth::user()->id
        ]);


        return response()->json(['success' => 'Order Added Successfully.']);
    }

    public function orders()
    {
        $deliveries = Delivery::with('product.category')->where('isConfirm', false)->latest()->get();
        return response()->json([
            'deliveries' =>   $deliveries,
        ]);
    }

    public function delete_order($id)
    {
        if ($id != "clear") {
            Delivery::where('id', $id)->where('isConfirm', false)->delete();
        } else {
            Delivery::where('isConfirm', false)->delete();
        }

        return response()->json(['success' => 'Removed Successfully.']);
    }
    public function confirm_order()
    {
        $orders = Delivery::where('isConfirm', false)->first();
        if ($orders != null) {
            PurchaseOrder::create([
                'user_id' => auth()->user()->id,
            ]);
            $porder = PurchaseOrder::orderBy('id', 'desc')->first();
            $pid = $porder->id ?? 1;

            Delivery::where('isConfirm', false)->update([
                'isConfirm' => true,
                'purchase_order_id' => $pid,
            ]);
        }
        Activity::create([
            'activity' => 'Pruchase Order',
            'user_id' => Auth::user()->id
        ]);


        return response()->json(['success' => 'Confirm Orders Successfully.']);
    }

    public function receipt_order($id)
    {
        if ($id == 'new_created') {
            $order = PurchaseOrder::orderBy('id', 'desc')->first();
            $suppliers = Delivery::latest()->orWhereNotNull('supplier')->select('supplier')->groupBy('supplier')->pluck('supplier')->toArray();
        } else {
            $suppliers = Delivery::latest()->orWhereNotNull('supplier')->select('supplier')->groupBy('supplier')->pluck('supplier')->toArray();
            $order = PurchaseOrder::where('id', $id)->first();
        }
        return view('admin.purchase_order.receipt', compact('order', 'suppliers'));
    }


    public function verify_order($id)
    {
        $deliveries = Delivery::with('product')->where('isConfirm', true)->where('purchase_order_id', $id)->latest()->get();
        $order = PurchaseOrder::where('id', $id)->first();

        return response()->json([
            'deliveries' =>   $deliveries,
            'supplier' => $order->supplier,
        ]);
    }
    public function verify(Request $request)
    {

        foreach ($request->ids as $key => $id_deli) {
            $delivery = Delivery::where('id', $id_deli)->first();
            $unit_price = $delivery->unit_price;
            $total = $unit_price * $request->qty[$key];


            Delivery::where('id', $id_deli)->update([
                'supplier' => $request->supplier[$key],
                'unit' => $request->unit[$key],
                'expiration' => $request->expiration[$key],
                'qty' => $request->qty[$key],
                'total' => $total
            ]);
        }
        Activity::create([
            'activity' => 'Verify Purchase Order',
            'user_id' => Auth::user()->id
        ]);



        return response()->json([
            'success' =>   'Successfully updated',
        ]);
    }



    public function deliveries()
    {
        $orders = PurchaseOrder::latest()->get();
        $suppliers = PurchaseOrder::latest()->orWhereNotNull('supplier')->select('supplier')->groupBy('supplier')->pluck('supplier')->toArray();

        return view('admin.purchase_order.deliveries', compact('orders', 'suppliers'));
    }

    public function recieve_order($id)
    {

        PurchaseOrder::where('id', $id)->update([
            'isRecieve' => true,
        ]);

        $orders =  PurchaseOrder::where('id', $id)->first();

        foreach ($orders->deliveries()->get() as $order) {
            $product = Product::where('code', $order->product_code)
                ->increment('stock', $order->qty);
            $stockProduct = Product::where('code', $order->product_code)->first();

            StockHistory::create([
                'product_code' => $order->product_code,
                'stock' => $stockProduct->stock,
                'stock_expi' => $order->qty,
                'isOrder' => false,
                'expiration' => $order->expiration,
                'remarks' => "RECEIVING: " . $order->qty . "<br> TRANSACTION: 0<br> B.O: 0<br> TOTAL STOCK: " . $stockProduct->stock,
            ]);
        }

        Activity::create([
            'activity' => 'Recieve Purchase Order',
            'user_id' => Auth::user()->id
        ]);




        return response()->json([
            'success' =>   'Successfully updated',
        ]);
    }
}
