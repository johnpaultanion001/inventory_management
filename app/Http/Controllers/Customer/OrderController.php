<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;
use App\Models\OrderProduct;
use App\Models\Order;
use App\Models\ProductSizePrice;
use Validator;
use Carbon\Carbon;


class OrderController extends Controller
{
    public function view(Product $product){

        $product_d = [
            'name'         => $product->name,
            'category'     => $product->category->name,
            'image1'        => $product->image1,
            'image2'        => $product->image2,
            'image3'        => $product->image3,
            'image4'        => $product->image4,
            'image5'        => $product->image5,
            'description'        => $product->description,
            'stock'        => 'Stock: '. $product->stock,
            'price'        => 'Price: ₱ '. $product->unit_price,
            'size'        => 'Size: '. $product->size->name,
            'isStar'     => $product->reviewsIsStar(),
            'discount'    => '('.'Less ₱ '. $product->discount .')',
        ];

        $reviews = Review::where('product_id', $product->id)
                            ->latest()
                            ->get();

        foreach($reviews as $review){
            $reviews1[] = array(
                'name'              => $review->user->name, 
                'review'            => $review->review,
                'isStar'            => $review->isStar,
                'date_time'         => $review->created_at->diffForHumans(),
            );
        }
        

        return response()->json([
            'product'      =>  $product_d,
            'reviews'  => $reviews1 ?? '',
        ]);

    }

    public function order(Request $request, Product $product)
    {
        date_default_timezone_set('Asia/Manila');
        $validated =  Validator::make($request->all(), [
            'qty'  => ['required' ,'integer','min:1','max:3'],
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        }

        if($request->input('qty') > $product->stock){
            return response()->json(['errorstock' => 'Must be less than the stock.']);
        }
                        
        $amount = $product->unit_price * $request->input('qty');
        $discounted = $product->discount * $request->input('qty');
        $total_amt = $amount - $discounted;

        OrderProduct::updateOrcreate(
            [
                'user_id'    => auth()->user()->id,
                'product_id' => $product->id,
                'isCheckout' => false,
            ],
            [
                'user_id'    => auth()->user()->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'qty'        => $request->input('qty'),
                'amount'     => $total_amt,
                'discounted' => $discounted,
                'price'      => $product->unit_price,
            ]
        );

        return response()->json(['success' => 'Ordered Successfully.']);
    }

    public function orders(){
        date_default_timezone_set('Asia/Manila');
        $orders = OrderProduct::where('user_id', auth()->user()->id)
                                 ->where('isCheckout', false)
                                 ->latest()
                                 ->get();

        return view('customer.orders',compact('orders'));
    }
    public function edit(OrderProduct $order){

        $orders = [
            'name'         => $order->product->name,
            'category'     => $order->product->category->name,

            'image1'        => $order->product->image1,
            'image2'        => $order->product->image2,
            'image3'        => $order->product->image3,
            'image4'        => $order->product->image4,
            'image5'        => $order->product->image5,
            
            'qty'          => $order->qty,

            'stock'        => 'Stock: '. $order->product->stock,
            'price'        => 'Price: ₱ '. $order->price,
            'size'        => 'Size: '. $order->product->size->name,
            'isStar'     => $order->product->reviewsIsStar(),
            'discount'    => '('.'Less ₱ '. $order->product->discount .')',


            'description'  =>  $order->product->description ?? '',
        ];

        $reviews = Review::where('product_id', $order->product->id)
                            ->latest()
                            ->get();
        
        foreach($reviews as $review){
            $reviews1[] = array(
                'name'              => $review->user->name, 
                'review'            => $review->review,
                'isStar'            => $review->isStar,
                'date_time'         => $review->created_at->diffForHumans(),
            );
        }
        

        return response()->json([
            'order'      =>  $orders,
            'reviews'  => $reviews1 ?? '',
        ]);


    }

    public function update(Request $request, OrderProduct $order)
    {
        date_default_timezone_set('Asia/Manila');
        $validated =  Validator::make($request->all(), [
            'qty'  => ['required' ,'integer','min:1','max:3',],
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        }


        if($request->input('qty') > $order->product->stock){
            return response()->json(['errorstock' => 'Must be less than the stock.']);
        }
                        
      
        $amount = $order->product->unit_price * $request->input('qty');
        $discounted = $order->product->discount * $request->input('qty');
        $total_amt = $amount - $discounted;


        OrderProduct::find($order->id)->update(
            [
                'qty'        => $request->input('qty'),
                'amount'     => $total_amt,
                'discounted' => $discounted,
                'price'      => $order->product->unit_price,
            ]
        );

        return response()->json(['success' => 'Ordered Updated Successfully.']);
    }

    public function cancel(OrderProduct $order){
        $order->delete();
        return response()->json(['success' => 'Ordered Canceled Successfully.']);
    }

    public function checkout(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $orderproducts = OrderProduct::where('user_id', auth()->user()->id)
                            ->where('isCheckout', false)->get();

        $ordercount = OrderProduct::where('user_id', auth()->user()->id)
                                    ->where('isCheckout', false)->count();

        if($ordercount < 1){
            return response()->json(['nodata' => 'No data available']);
        }       
        if($request->input('shipping_option') == 'pickUp'){
            $fee = 0;
            $total_amount = $orderproducts->sum->amount;
            $total = $fee + $total_amount;
        }else{
            $fee = auth()->user()->shippingFee->fee;
            $total_amount = $orderproducts->sum->amount;
            $total = $fee + $total_amount;
        }
        
        if ($request->file('upload_receipt')) {
            $resibo = $request->file('upload_receipt');
            $extension = $resibo->getClientOriginalExtension(); 
            $file_name_to_save = time()."_".".".$extension;
            $resibo->move('assets/img/resibo/', $file_name_to_save);
        }

        $orders = Order::create([
            'user_id'   => auth()->user()->id,
            'shipping_option' => $request->input('shipping_option'),
            'payment_option' => $request->input('payment_option'),
            'shipping_fee'  => $fee,
            'total_amount' => $total,
            'payment_receipt' => $file_name_to_save ?? '',
            'note' => $request->input('note'),
        ]);
        foreach($orderproducts as $order){
                if($order->qty > $order->product->stock){
                    Order::find($orders->id)->delete();
                    return response()->json(['no_stock' => 'Out of stock <br>
                                                            Product: '.$order->product->name.
                                                            '<br> Qty: '.$order->qty. 
                                                            '<br> Available Stock: '.$order->product->stock]);
                }else{
                    Product::where('id', $order->product_id)->decrement('stock', $order->qty);
                    OrderProduct::where('id', $order->id)
                                    ->update([
                                        'order_id' => $orders->id,
                                        'isCheckout' => true,
                                    ]);
                }

        }
        return response()->json(['success' => 'Ordered Successfully Checkout.']);
        
    }
    
    public function orders_history(){
        $orders = Order::where('user_id', auth()->user()->id)
                            ->where('status', "PENDING")->latest()->get();
        $orders_approved = Order::where('user_id', auth()->user()->id)
                            ->where('status', "APPROVED")->latest()->get();

        return view('customer.orders_history' ,compact('orders' , 'orders_approved'));
    }
    public function cancel_order(Order $order, Request $request){
        Order::find($order->id)
            ->update([
                'status'    => 'CANCELLED',
                'cancel_reason' => $request->input('reason'),
            ]);

      

        foreach($order->orderproducts()->get() as $order_p){
            Product::where('id', $order_p->product->id)
                    ->increment('stock', $order_p->qty);
            
        }

        $order->orderproducts()->update([
            'status'    => 'CANCELLED',
        ]);


        return response()->json(['success' => 'Successfully Cancelled.']);
    }
    
   
}
