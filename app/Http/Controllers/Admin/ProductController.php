<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;
use File;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailNotification;
use App\Models\Activity;
use App\Models\StockHistory;
use Illuminate\Support\Facades\Auth;



class ProductController extends Controller
{

    public function index()
    {

        date_default_timezone_set('Asia/Manila');

        $products = Product::latest()->get();
        $categories = Category::latest()->get();
        $ldate = date('M j , Y');

        return view('admin.products', compact('products', 'categories','ldate'));

        return abort('403');
    }

    public function detail_product()
    {
        $categories = Category::latest()->get();
        return view('admin.detail_product', compact('categories'));
    }

    public function scan_product($code)
    {
        $productWCode = Product::where('code',$code)->first();
        return response()->json(
            [
                "product" =>  $productWCode,
                "expiration" => $productWCode->stocksWExpiFirst()->expiration,
                "category" => $productWCode->category->name,
                "orders" =>  $productWCode->orders()->latest()->get(),
                "stocks" =>  $productWCode->stocks()->latest()->get(),
                "expirations" =>  $productWCode->stocksWExpi()->latest()->get(),

            ],

        );
    }



    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $validated =  Validator::make($request->all(), [
            'description' => ['required'],
            'code' => ['required','unique:products'],
            'unit' => ['required'],
            'category' => ['required'],
            'stock' => ['required','integer','min:1'],
            'unit_price' => ['required','integer','min:1'],
            //'price' => ['required'],
            'expiration' => ['required','date', 'after:today'],
            'image1' =>  ['mimes:png,jpg,jpeg,svg,bmp,ico'],
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        }
        if ($request->file('image1')) {
            $imgs1 = $request->file('image1');
            $extension1 = $imgs1->getClientOriginalExtension();
            $file_name_to_save1 = time()."_1".".".$extension1;
            $imgs1->move('assets/img/products/', $file_name_to_save1);
        }

        $total_price = $request->input('unit_price') * $request->input('stock');

        $product = Product::create([
            'description' => $request->input('description'),
            'code' => $request->input('code'),
            'unit' => $request->input('unit'),
            'category_id' => $request->input('category'),
            'stock' => $request->input('stock'),
            'unit_price' => $request->input('unit_price'),
            'price' => $total_price,
            'expiration' => $request->input('expiration'),

            'image1' => $file_name_to_save1 ?? "",
        ]);

        \App\Models\StockHistory::create([
            'product_code' => $request->input('code'),
            'stock' => $request->input('stock'),
            'stock_expi' => $request->input('stock'),
            'expiration'=> $request->input('expiration'),
            'isOrder' => false,
            'remarks' => "Newly created",
        ]);

        Activity::create([
            'activity' => 'Created product',
            'user_id' => Auth::user()->id
        ]);


        return response()->json(['success' => 'Product Added Successfully.']);
    }


    public function edit(Product $product)
    {
        return response()->json([
            'result' =>   $product,
        ]);
    }

    public function stock($product, Request $request)
    {
        if($request->get('type')){
            $products = StockHistory::where('id',$product)->first();
            return response()->json([
                'stock' =>   $products->stock_expi,
                'expiration' => $products->expiration,
            ]);
        }else{
            $products = Product::where('id',$product)->first();
            return response()->json([
                'stock' =>   $products->stock,
            ]);
        }

    }

    public function updateproduct(Request $request, Product $product)
    {
        date_default_timezone_set('Asia/Manila');
        $validated =  Validator::make($request->all(), [
            'description' => ['required'],
            'code' => ['required'],
            'unit' => ['required'],
            'category' => ['required'],


            'image1' =>  ['mimes:png,jpg,jpeg,svg,bmp,ico'],


        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        }

        if ($request->file('image1')) {
            File::delete(public_path('assets/img/products/'.$product->image1));
            $imgs1 = $request->file('image1');
            $extension1 = $imgs1->getClientOriginalExtension();
            $file_name_to_save1 = time()."_1".".".$extension1;
            $imgs1->move('assets/img/products/', $file_name_to_save1);

            $product->image1 = $file_name_to_save1;
        }

        $product->description = $request->description;
        $product->code = $request->code;
        $product->unit = $request->unit;
        $product->category_id = $request->category;

        $product->expiration = $request->expiration;
        $product->save();

        Activity::create([
            'activity' => 'Updated product',
            'user_id' => Auth::user()->id
        ]);

        return response()->json([
            'success' => 'Product Updated Successfully.',
            "product" =>  $product,
            "stocks" =>  $product->stocks()->latest()->get(),
            "category" => $product->category->name,
        ]);
    }

    public function update_stock(Request $request, $product)
    {
        date_default_timezone_set('Asia/Manila');
        if($request->input('type') == null){
            $product = Product::where('id', $product)->first();
            $manage_stock = (float)$request->input('manage_stock');
            $receiving = (float)$request->input('receiving');
            $transaction = (float)$request->input('transaction');
            $bad_order = (float)$request->input('bad_order');

            $stock = (float)$product->stock;


            if($receiving < 1){
                $expiration_valid = ['nullable','date'];
                $isOrder = true;
            }else{
                $expiration_valid = ['required','date', 'after:today'];
                $isOrder = false;
            }

            $validated =  Validator::make($request->all(), [
                'manage_stock' => ['required','integer','min:1'],
                'receiving' => ['required','integer','min:0'],
                'transaction' => ['required','integer','min:0'],
                'bad_order' => ['required','integer','min:0'],
                'expiration_stock' => $expiration_valid,
            ]);

            if ($validated->fails()) {
                return response()->json(['errors' => $validated->errors()]);
            }
            //computation of stock
            $final_stock = $stock + $receiving - $transaction - $bad_order;
            \App\Models\StockHistory::create([
                'product_code' => $product->code,
                'stock' => $final_stock,
                'stock_expi' => $receiving,
                'expiration'=> $request->expiration_stock,
                'isOrder' => $isOrder,
                'remarks' => "RECEIVING: ".$receiving ."<br> TRANSACTION: ".$transaction."<br> B.O: ".$bad_order."<br> TOTAL STOCK: ".$final_stock,
            ]);

            if($transaction > 1){
                $qty = $transaction;
                $amount = $qty * $product->unit_price;

                \App\Models\OrderProduct::create([
                    'product_code' => $product->code,
                    'description' => $product->description,
                    'qty' => $qty,
                    'amount' => $amount,
                    'price' => $product->unit_price,
                    'category' => $product->category->name,
                ]);

            }
            //email sending
            if($final_stock < 6){
                $emailNotif = [
                    'msg'              => "PRODUCT LOWER STOCK",
                    'code'              =>  $product->code,
                    'description'              =>   $product->description,
                    'stock'              =>   $product->stock,
                    'updated_by'              =>  auth()->user()->name,
                ];
                $critStock = 1;
                //Mail::to('johnpaultanion001@gmail.com')
                //->send(new EmailNotification($emailNotif));
            }else{
                $critStock = 0;
            }

            Activity::create([
                'activity' => 'Updated stock',
                'user_id' => Auth::user()->id
            ]);

            $product->stock = $final_stock;
            $product->save();

            return response()->json([
                'success' => 'Stock Updated Successfully.',
                "product" =>  $product,
                "stocks" =>  $product->stocks()->latest()->get(),
                "orders" => $product->orders()->latest()->get(),
                "category" => $product->category->name,
                "critStock" => $critStock,
                "expirations" =>  $product->stocksWExpi()->latest()->get(),
            ]);
        }else{
            $expi_id = $request->input('hidden_id_stock');

            $validated =  Validator::make($request->all(), [
                'expiration_stock' =>  ['required','date', 'after:today']
            ]);

            if ($validated->fails()) {
                return response()->json(['errors' => $validated->errors()]);
            }
            StockHistory::where('id',$expi_id)->update([
                "expiration" => $request->input('expiration_stock')
            ]);
            $expi_product = StockHistory::where('id', $expi_id)->first();
            $expi = Product::where('code',$expi_product->product_code)->first();

            return response()->json([
                'success' => 'Expiration Updated Successfully.',
            ]);

        }

    }

    // public function update_stock(Request $request, $product)
    // {
    //     date_default_timezone_set('Asia/Manila');
    //     if($request->input('type') == null){
    //         $product = Product::where('id', $product)->first();
    //         $manage_stock = (float)$request->input('manage_stock');
    //         $stock = (float)$product->stock;


    //         if($stock > $manage_stock){
    //             $expiration_valid = ['nullable','date'];
    //             $isOrder = true;
    //         }
    //         elseif($stock == $manage_stock){
    //             $expiration_valid = ['nullable','date'];
    //             $isOrder = true;
    //         }else{
    //             $expiration_valid = ['required','date', 'after:today'];
    //             $isOrder = false;
    //         }

    //         $validated =  Validator::make($request->all(), [
    //             'manage_stock' => ['required','integer','min:1'],
    //             'expiration_stock' => $expiration_valid,
    //         ]);

    //         if ($validated->fails()) {
    //             return response()->json(['errors' => $validated->errors()]);
    //         }

    //         if($request->input('manage_stock') != $product->stock){
    //             $stock_expi = $manage_stock - $stock;
    //             \App\Models\StockHistory::create([
    //                 'product_code' => $product->code,
    //                 'stock' => $request->manage_stock,
    //                 'stock_expi' => $stock_expi,
    //                 'expiration'=> $request->expiration_stock,
    //                 'isOrder' => $isOrder,
    //                 'remarks' => "Stock change from ".$product->stock." to ". $request->manage_stock,
    //             ]);



    //             if($stock > $manage_stock){
    //                 $qty = $stock - $manage_stock;
    //                 $amount = $qty * $product->unit_price;

    //                 \App\Models\OrderProduct::create([
    //                     'product_code' => $product->code,
    //                     'description' => $product->description,
    //                     'qty' => $qty,
    //                     'amount' => $amount,
    //                     'price' => $product->unit_price,
    //                     'category' => $product->category->name,
    //                 ]);

    //             }


    //             //email sending
    //             if($manage_stock < 6){
    //                 $emailNotif = [
    //                     'msg'              => "PRODUCT LOWER STOCK",
    //                     'code'              =>  $product->code,
    //                     'description'              =>   $product->description,
    //                     'stock'              =>   $product->stock,
    //                     'updated_by'              =>  auth()->user()->name,
    //                 ];
    //                 $critStock = 1;
    //                 // Mail::to('johnpaultanion001@gmail.com')
    //                 // ->send(new EmailNotification($emailNotif));
    //             }else{
    //                 $critStock = 0;
    //             }

    //             Activity::create([
    //                 'activity' => 'Updated stock',
    //                 'user_id' => Auth::user()->id
    //             ]);

    //             $product->stock = $request->manage_stock;
    //             $product->save();
    //         }

    //         return response()->json([
    //             'success' => 'Stock Updated Successfully.',
    //             "product" =>  $product,
    //             "stocks" =>  $product->stocks()->latest()->get(),
    //             "orders" => $product->orders()->latest()->get(),
    //             "category" => $product->category->name,
    //             "critStock" => $critStock,
    //             "expirations" =>  $product->stocksWExpi()->latest()->get(),
    //         ]);
    //     }else{
    //         $expi_id = $request->input('hidden_id_stock');

    //         $validated =  Validator::make($request->all(), [
    //             'expiration_stock' =>  ['required','date', 'after:today']
    //         ]);

    //         if ($validated->fails()) {
    //             return response()->json(['errors' => $validated->errors()]);
    //         }
    //         StockHistory::where('id',$expi_id)->update([
    //             "expiration" => $request->input('expiration_stock')
    //         ]);
    //         $expi_product = StockHistory::where('id', $expi_id)->first();
    //         $expi = Product::where('code',$expi_product->product_code)->first();

    //         return response()->json([
    //             'success' => 'Expiration Updated Successfully.',
    //         ]);

    //     }

    // }



    public function destroy(Product $product)
    {
        File::delete(public_path('assets/img/products/'.$product->image1));
        $product->delete();
        Activity::create([
            'activity' => 'Delete product',
            'user_id' => Auth::user()->id
        ]);
        return response()->json(['success' =>  'Product Removed Successfully.']);
    }
}
