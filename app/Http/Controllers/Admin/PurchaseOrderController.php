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

        return view('admin.purchase_order.purchase_order', compact('products', 'categories','deliveries'));
    }
    public function order(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $validated =  Validator::make($request->all(), [
            'unit_order' => ['required'],
            'qty_order' => ['required','integer','min:1'],
            'expiration_order' => ['required','date', 'after:today'],
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        }

        $product = Product::where('id',$request->input('product_id'))->first();

        $unit_price = $product->unit_price;
        $total = $product->unit_price * $request->input('qty_order');

        Delivery::create([
            'product_id' => $request->input('product_id'),
            'product_code' => $request->input('order_code'),
            'unit' => $request->input('unit_order'),
            'qty' => $request->input('qty_order'),
            'unit_price' => $unit_price,
            'expiration' => $request->input('expiration_order'),
            'total' => $total,
        ]);

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

    public function delete_order($id){
        if($id != "clear"){
            Delivery::where('id',$id)->where('isConfirm',false)->delete();
        }else{
            Delivery::where('isConfirm',false)->delete();
        }

        return response()->json(['success' => 'Removed Successfully.']);
    }
    public function confirm_order(){
        $orders = Delivery::where('isConfirm',false)->first();
        if($orders != null){
            PurchaseOrder::create([
                'user_id' => auth()->user()->id,
            ]);
            $porder = PurchaseOrder::orderBy('id','desc')->first();
            $pid = $porder->id ?? 1;

            Delivery::where('isConfirm',false)->update([
                'isConfirm' => true,
                'purchase_order_id' => $pid,
            ]);

            foreach($porder->deliveries()->get() as $order){
                $product = Product::where('code',$order->product_code)
                                ->increment('stock', $order->qty);
                $stockProduct = Product::where('code',$order->product_code)->first();

                StockHistory::create([
                    'product_code' => $order->product_code,
                    'stock' => $stockProduct->stock,
                    'stock_expi' => $order->qty,
                    'isOrder' => false,
                    'expiration' => $order->expiration,
                    'remarks' => "RECEIVING: ".$order->qty ."<br> TRANSACTION: 0<br> B.O: 0<br> TOTAL STOCK: ".$stockProduct->stock,
                ]);
            }

        }

        return response()->json(['success' => 'Confirm Orders Successfully.']);
    }

    public function receipt_order($id){
        if($id == 'new_created'){
           $order = PurchaseOrder::orderBy('id','desc')->first();
        }else{
            $order = PurchaseOrder::where('id',$id)->first();
        }
        return view('admin.purchase_order.receipt' ,compact('order'));
    }


    public function deliveries(){
        $orders = PurchaseOrder::latest()->get();

        return view('admin.purchase_order.deliveries' ,compact('orders'));
    }





}
