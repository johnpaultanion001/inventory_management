<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingFee;
use Illuminate\Http\Request;
use Validator;

class ShippingFeeController extends Controller
{
    public function index()
    {
        $userrole = auth()->user()->role;
        if($userrole != 'customer'){
            date_default_timezone_set('Asia/Manila');
            $fees = ShippingFee::latest()->get();

            return view('admin.fees', compact('fees'));
        }
        return abort('403');
    }

    
   
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $validated =  Validator::make($request->all(), [
            'city' => ['required', 'string', 'max:255'],
            'fee' => ['required','integer','min:1'],
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        }

        ShippingFee::create([
            'city' => $request->input('city'),
            'fee' => $request->input('fee'),
        ]);

        return response()->json(['success' => 'Added Successfully.']);
    }

    

    public function edit(ShippingFee $fee)
    {
        if (request()->ajax()) {
            return response()->json(
                ['result' =>  $fee]
            );
        }
    }

   
    public function update(Request $request, ShippingFee $fee)
    {
        date_default_timezone_set('Asia/Manila');
        $validated =  Validator::make($request->all(), [
            'city' => ['required', 'string', 'max:255'],
            'fee' => ['required','integer','min:1'],
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        }

        $fee->update([
            'city' => $request->input('city'),
            'fee' => $request->input('fee'),
        ]);

        return response()->json(['success' => 'Updated Successfully.']);
    }

    public function destroy(ShippingFee $fee)
    {
        $fee->delete();
        return response()->json(['success' =>  'Removed Successfully.']);
    }
}
