<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LayoutStyle;
use Validator;
use File;

class LayoutStyleController extends Controller
{
    public function index()
    {
        $userrole = auth()->user()->role;
        if($userrole == 'staff'){
            date_default_timezone_set('Asia/Manila');
            $styles = LayoutStyle::where('id',1)->first();

            return view('admin.styles', compact('styles'));
        }
        return abort('403');
    }

    public function update(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $styles = LayoutStyle::where('id',1)->first();
       
        if ($request->file('navbar_logo')) {
            File::delete(public_path('assets/img/'.$styles->navbar_logo));
            $navbar_logo = $request->file('navbar_logo');
            $navbar_logo_extension1 = $navbar_logo->getClientOriginalExtension(); 
            $file_name_to_save1 = time()."_navbar_logo".".".$navbar_logo_extension1;
            $navbar_logo->move('assets/img/', $file_name_to_save1);
            $styles->navbar_logo = $file_name_to_save1;
        }
        if ($request->file('banner_logo')) {
            File::delete(public_path('assets/img/'.$styles->banner_logo));
            $banner_logo = $request->file('banner_logo');
            $banner_logo_extension1 = $banner_logo->getClientOriginalExtension(); 
            $file_name_to_save2 = time()."_banner_logo".".".$banner_logo_extension1;
            $banner_logo->move('assets/img/', $file_name_to_save2);
            $styles->banner_logo = $file_name_to_save2;
        }
        if ($request->file('footer_logo')) {
            File::delete(public_path('assets/img/'.$styles->footer_logo));
            $footer_logo = $request->file('footer_logo');
            $footer_logo_extension1 = $footer_logo->getClientOriginalExtension(); 
            $file_name_to_save3 = time()."_footer_logo".".".$footer_logo_extension1;
            $footer_logo->move('assets/img/', $file_name_to_save3);
            $styles->footer_logo = $file_name_to_save3;
        }

        if ($request->file('slider_image1')) {
            File::delete(public_path('assets/img/'.$styles->slider_image1));
            $slider_image1 = $request->file('slider_image1');
            $slider_image1_extension1 = $slider_image1->getClientOriginalExtension(); 
            $slider1 = time()."_slider1".".".$slider_image1_extension1;
            $slider_image1->move('assets/img/', $slider1);
            $styles->slider_image1 = $slider1;
        }
        if ($request->file('slider_image2')) {
            File::delete(public_path('assets/img/'.$styles->slider_image2));
            $slider_image2 = $request->file('slider_image2');
            $slider_image2_extension2 = $slider_image2->getClientOriginalExtension(); 
            $slider2 = time()."_slider2".".".$slider_image2_extension2;
            $slider_image2->move('assets/img/', $slider2);
            $styles->slider_image2 = $slider2;
        }
        if ($request->file('slider_image3')) {
            File::delete(public_path('assets/img/'.$styles->slider_image3));
            $slider_image3 = $request->file('slider_image3');
            $slider_image3_extension3 = $slider_image3->getClientOriginalExtension(); 
            $slider3 = time()."_slider3".".".$slider_image3_extension3;
            $slider_image3->move('assets/img/', $slider3);
            $styles->slider_image3 = $slider3;
        }
        if ($request->file('slider_image4')) {
            File::delete(public_path('assets/img/'.$styles->slider_image4));
            $slider_image4 = $request->file('slider_image4');
            $slider_image4_extension4 = $slider_image4->getClientOriginalExtension(); 
            $slider4 = time()."_slider4".".".$slider_image4_extension4;
            $slider_image4->move('assets/img/', $slider4);
            $styles->slider_image4 = $slider4;
        }
        if ($request->file('slider_image5')) {
            File::delete(public_path('assets/img/'.$styles->slider_image5));
            $slider_image5 = $request->file('slider_image5');
            $slider_image5_extension5 = $slider_image5->getClientOriginalExtension(); 
            $slider5 = time()."_slider5".".".$slider_image5_extension5;
            $slider_image5->move('assets/img/', $slider5);
            $styles->slider_image5 = $slider5;
        }


        

        $styles->navbar_color = $request->navbar_color;
        $styles->navbar_text_color = $request->navbar_text_color;

        $styles->banner_color = $request->banner_color;
        $styles->banner_text_color = $request->banner_text_color;

        $styles->footer_color = $request->footer_color;
        $styles->footer_text_color = $request->footer_text_color;
    
  
        $styles->save();

        return response()->json(['success' => 'Updated Successfully.']);
    }
}
