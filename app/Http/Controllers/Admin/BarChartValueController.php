<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Category;

class BarChartValueController extends Controller
{

    public function trend_projection($category, $month){


        $years_dropdown  = OrderProduct::selectRaw('YEAR(created_at) as year , sum(qty) as sold')
                            ->where('category',$category)
                            ->whereMonth('created_at', '=', $month)
                            ->orderBy('year')
                            ->groupBy('year')->get();
        $year_sold = array();
        foreach($years_dropdown as $year ){
            array_push($year_sold, [$year->year => $year->sold]);
        }

        $dataFocast = array();
        foreach($year_sold as $key => $value) {
            foreach($value as $key2 => $value2) {
                $dataFocast[$key2] = $value2;
            }
        }


        // Calculate the mean of X and Y values
        $x_mean = array_sum(array_keys($dataFocast)) / count($dataFocast);
        $y_mean = array_sum(array_values($dataFocast)) / count($dataFocast);

        // Calculate the covariance and variance of X and Y
        $covariance = 0;
        $variance = 0;

        foreach ($dataFocast as $x => $y) {
            $covariance += ($x - $x_mean) * ($y - $y_mean);
            $variance += ($x - $x_mean) * ($x - $x_mean);
        }

        // Calculate the slope and intercept of the trend line
        $slope = $covariance / $variance;
        $intercept = $y_mean - ($slope * $x_mean);

        return function ($x) use ($slope, $intercept) {
            // Generate forecast for period X
            return $slope * $x + $intercept;
        };
    }

    public function forcast(){
        // Calculate the trend projection function
        $trend = $this->trend_projection("BEVERAGES",1);

        // Generate forecast for 2024
        $forecast_2024   = $trend(2027);


       return dd($forecast_2024);

    }


    public function index($year)
    {
        $categories = Category::orderBy('name')->get();
        $montly_sold = [];
        $forcasts = [];
        if($year < date('Y') + 1){
            foreach ($categories as $category) {
                array_push($montly_sold, [
                       $jan = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 1)->sum('qty'),
                       $feb = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 2)->sum('qty'),
                       $mar = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 3)->sum('qty'),
                       $apr = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 4)->sum('qty'),
                       $may = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 5)->sum('qty'),
                       $june = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 6)->sum('qty'),
                       $july = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 7)->sum('qty'),
                       $aug = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 8)->sum('qty'),
                       $sept = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 9)->sum('qty'),
                       $oct = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 10)->sum('qty'),
                       $nov = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 11)->sum('qty'),
                       $dec = OrderProduct::where('category', $category->name)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 12)->sum('qty'),
                       $category->name,
                ]);
            }
        }else{
            foreach ($categories as $category) {
                array_push($montly_sold, [
                       $jan = number_format($this->trend_projection($category->name,1)($year) , 2, '.', ','),
                       $feb = number_format($this->trend_projection($category->name,2)($year) , 2, '.', ','),
                       $mar = number_format($this->trend_projection($category->name,3)($year) , 2, '.', ','),
                       $apr = number_format($this->trend_projection($category->name,4)($year) , 2, '.', ','),
                       $may = number_format($this->trend_projection($category->name,5)($year) , 2, '.', ','),
                       $june = number_format($this->trend_projection($category->name,6)($year) , 2, '.', ','),
                       $july = number_format($this->trend_projection($category->name,7)($year) , 2, '.', ','),
                       $aug = number_format($this->trend_projection($category->name,8)($year) , 2, '.', ','),
                       $sept = number_format($this->trend_projection($category->name,9)($year) , 2, '.', ','),
                       $oct = number_format($this->trend_projection($category->name,10)($year) , 2, '.', ','),
                       $nov = number_format($this->trend_projection($category->name,11)($year) , 2, '.', ','),
                       $dec = number_format($this->trend_projection($category->name,12)($year) , 2, '.', ','),
                       $category->name,
                ]);
            }
        }


        $chart_filter  = 'From: ' .'Jan 1, ' . $year . ' To: ' .'Dec 31, ' . $year;



        return view('admin.sales_reports.bar_chart_value',compact('montly_sold','chart_filter','year'));

    }
}
