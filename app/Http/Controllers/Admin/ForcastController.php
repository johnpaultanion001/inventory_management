<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Forcast;
use App\Models\OrderProduct;
use Validator;

class ForcastController extends Controller
{

    public function edit($forcast, Request $request)
    {
        if($forcast == 2024){
            $month = date("m", strtotime($request->get('month')));
            $category = $request->get('category');

            $c2021 = OrderProduct::where('category', $category)->whereYear('created_at', '=', '2021')->whereMonth('created_at', '=', $month)->sum('qty');
            $c2022 = OrderProduct::where('category', $category)->whereYear('created_at', '=', '2022')->whereMonth('created_at', '=', $month)->sum('qty');
            $c2023 = OrderProduct::where('category', $category)->whereYear('created_at', '=', '2023')->whereMonth('created_at', '=', $month)->sum('qty');

            $var = ltrim($month, '0');
            $c2024 = Forcast::where('category', $category)->where('month', '=', $var)->sum('total');

            $tp2024 = OrderProduct::groupBy('description')->where('category', $category)->whereMonth('created_at', '=', $month)->selectRaw('sum(qty) as total, description')->orderBy('total','desc')->take(3)->get();


            $forcasting = [
                [
                    "category" => $category,
                    "year" => "2021",
                    "month" => $request->get('month'),
                    "demand" => $c2021,
                    "class" => "",

                ],
                [
                    "category" => $category,
                    "year" => "2022",
                    "month" => $request->get('month'),
                    "demand" => $c2022,
                    "class" => "",

                ],
                [
                    "category" => $category,
                    "year" => "2023",
                    "month" => $request->get('month'),
                    "demand" => $c2023,
                    "class" => "",

                ],
                [
                    "category" => $category,
                    "year" => "2024",
                    "month" => $request->get('month'),
                    "demand" => $c2024,
                    "class" => "table-success",

                ],

            ];
            // /regression/jan/BEVERAGES.png
            $regression = '/regression/' .$request->get('month').'/'.$category.'.png';


            return response()->json(
                [
                    'forcasting' =>  $forcasting,
                    'tp2024' => $tp2024,
                    'regression' => $regression,
                ]
            );

        }else{
            $forcasts = Forcast::where('id',$forcast)->first();
            $c2021 = OrderProduct::where('category', $forcasts->category)->whereYear('created_at', '=', '2021')->whereMonth('created_at', '=', $forcasts->month)->sum('qty');
            $c2022 = OrderProduct::where('category', $forcasts->category)->whereYear('created_at', '=', '2022')->whereMonth('created_at', '=', $forcasts->month)->sum('qty');
            $c2023 = OrderProduct::where('category', $forcasts->category)->whereYear('created_at', '=', '2023')->whereMonth('created_at', '=', $forcasts->month)->sum('qty');

            return response()->json(
                [
                    'result' =>  $forcasts,
                    'c2021' => $c2021,
                    'c2022' => $c2022,
                    'c2023' => $c2023,
                ]
            );
        }


    }


    public function update(Request $request, Forcast $forcast)
    {
        date_default_timezone_set('Asia/Manila');
        $validated =  Validator::make($request->all(), [
            'total' => ['required','integer','min:0'],
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        }

        Forcast::find($forcast->id)->update([
            'total' => $request->input('total'),
        ]);

        return response()->json(['success' => 'Updated Successfully.']);
    }
}
