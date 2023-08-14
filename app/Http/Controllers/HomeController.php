<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        $products = Product::orderBy('category_id', 'asc')->get();
        return view('customer.home' , compact('products','categories'));
    }

    public function about()
    {
        $test = 'for testing';
        return view('customer.about', compact('test'));
    }

    public function filter(Request $request){
        $filter = $request->get('filter');
        $value  = $request->get('value');

        if($filter == 'search'){
            $data = Product::where('name', 'LIKE', "%$value%")->latest()->get();
        }

        if($filter == 'category'){
            if($value == ''){
                $data = Product::orderBy('category_id', 'asc')->get();
            }else{
                $data = Product::where('category_id', $value)->orderBy('category_id', 'asc')->get();
            }
        }

        if($filter == 'onhand'){
        
            $data = Product::orderBy('category_id', 'asc')->get();
            
        }
        if($filter == 'new_arrivals'){
        
            $data = Product::latest()->get();
            
        }

        
        
        foreach($data as $item){
            $products[] = array(
                'id'           => $item->id,
                'name'         => $item->name,
                'category'     => $item->category->name,
                'image'        => $item->image1,
                'description'  => $item->description,
                'price'        => $item->unit_price,
                'status'       => $item->status,
                'status_color' => $item->status == 'ONHAND' ? 'bg-success':'bg-warning',
           );
        }
        return response()->json([
            'products'  => $products,
        ]);
    }

    
}
