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



class ProductController extends Controller
{

    public function index()
    {
        $userrole = auth()->user()->role;
        if($userrole != 'customer'){
            date_default_timezone_set('Asia/Manila');

            $products = Product::latest()->get();
            $categories = Category::latest()->get();

            return view('admin.products', compact('products', 'categories'));
        }
        return abort('403');
    }

    public function detail_product()
    {
        return view('admin.detail_product');
    }

    public function scan_product($code)
    {
        $productWCode = Product::where('code',$code)->first();
        return response()->json(
            [
                "product" =>  $productWCode,
                "orders" =>  $productWCode->orders()->latest()->get(),
                "stocks" =>  $productWCode->stocks()->latest()->get(),
            ],

        );
    }



    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $validated =  Validator::make($request->all(), [
            'description' => ['required'],
            'code' => ['required'],
            'unit' => ['required'],
            'area' => ['required'],
            'stock' => ['required','integer','min:1'],
            'unit_price' => ['required'],
            'price' => ['required'],


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

        $product = Product::create([
            'description' => $request->input('description'),
            'code' => $request->input('code'),
            'unit' => $request->input('unit'),
            'area' => $request->input('area'),
            'stock' => $request->input('stock'),
            'unit_price' => $request->input('unit_price'),
            'price' => $request->input('price'),

            'image1' => $file_name_to_save1 ?? "",
        ]);


        return response()->json(['success' => 'Product Added Successfully.']);
    }


    public function edit(Product $product)
    {
        return response()->json([
            'result' =>   $product,
        ]);
    }

    public function updateproduct(Request $request, Product $product)
    {
        date_default_timezone_set('Asia/Manila');
        $validated =  Validator::make($request->all(), [
            'description' => ['required'],
            'code' => ['required'],
            'unit' => ['required'],
            'area' => ['required'],
            'stock' => ['required','integer','min:1'],
            'unit_price' => ['required'],
            'price' => ['required'],


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
        if($request->input('stock') != $product->stock){
            \App\Models\StockHistory::create([
                'product_code' => $request->code,
                'stock' => $request->stock,
                'remarks' => "Stock change from ".$product->stock." to ". $request->stock,
            ]);
            $product->stock = $request->stock;

            //email sending
            if($product->stock < 6){
                $emailNotif = [
                    'msg'              => "PRODUCT LOWER STOCK",
                    'code'              =>  $product->code,
                    'description'              =>   $product->description,
                    'stock'              =>   $product->stock,
                    'updated_by'              =>  auth()->user()->name,
                ];

                Mail::to('johnpaultanion001@gmail.com')
                ->send(new EmailNotification($emailNotif));
            }
        }

        $product->description = $request->description;
        $product->code = $request->code;
        $product->unit = $request->unit;
        $product->area = $request->area;

        $product->unit_price = $request->unit_price;
        $product->price = $request->price;

        $product->save();

        return response()->json([
            'success' => 'Product Updated Successfully.',
            "product" =>  $product,
            "stocks" =>  $product->stocks()->latest()->get(),
        ]);
    }


    public function destroy(Product $product)
    {
        File::delete(public_path('assets/img/products/'.$product->image1));
        File::delete(public_path('assets/img/products/'.$product->image2));
        File::delete(public_path('assets/img/products/'.$product->image3));
        File::delete(public_path('assets/img/products/'.$product->image4));
        File::delete(public_path('assets/img/products/'.$product->image5));
        $product->delete();
        return response()->json(['success' =>  'Product Removed Successfully.']);
    }
}
