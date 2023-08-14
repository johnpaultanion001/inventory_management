<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function review(Request $request){
        Review::UpdateOrCreate(
            [
                'user_id'                   => auth()->user()->id,
                'product_id'                 => $request->input('product_id'),
                'order_id'                 => $request->input('order_id'),

            ],
            [
                'user_id'                   => auth()->user()->id,
                'product_id'                 => $request->input('product_id'),
                'order_id'                 => $request->input('order_id'),
                'isStar'                    => $request->input('isStar'),
                'review'                    => $request->input('review'),
            ]
        );

        $reviews = Review::where('product_id', $request->input('product_id'))
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
            'reviews'  => $reviews1,
            'product_id'  => $request->input('product_id'),
        ]);
    }
}
