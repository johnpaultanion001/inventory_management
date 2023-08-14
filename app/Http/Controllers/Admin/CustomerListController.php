<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\Rules\MatchOldPassword;

class CustomerListController extends Controller
{
    public function index()
    {
        $userrole = auth()->user()->role;
        if($userrole != 'customer'){
            $customers = User::where('role', 'customer')->latest()->get();
            return view('admin.customerlist', compact('customers'));
        }
        return abort('403');
    }

    public function status(User $user, Request $request){
        if($user->isApproved == true){
            User::find($user->id)->update([
                'isApproved'    => false,
            ]);
        }

        if($user->isApproved == false){
            User::find($user->id)->update([
                'isApproved'    => true,
            ]);
        }
        
        return response()->json(['success' => 'Updated Successfully.']);

    }

    public function edit(User $user)
    {
        if (request()->ajax()) {
            return response()->json(['result' => $user]);
        }
    }

    public function update(Request $request, User $user)
    {
        date_default_timezone_set('Asia/Manila');
        $validated =  Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required'],
            'contact_number' => ['required', 'string', 'min:8','max:11'],
            
        ]);
        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        }

        User::find($user->id)->update([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'contact_number' => $request->input('contact_number'),
        ]);

        return response()->json(['success' => 'Updated Successfully.']);
    
      
    }

    public function defaultPassowrd(User $user)
    {
        User::find($user->id)->update([
            'password' => '$2y$10$zPiaTbYwkxYcejFmEimhWedeAogTJvEb/yGmBVx390ihhPFy8r896' , //password,
        ]);
        return response()->json(['success' => 'Updated Successfully.']);
    }


    // ADMIN FUNCTION

    public function staff_index(){
        $userrole = auth()->user()->role;
        if($userrole == 'admin'){
            $admins = User::where('role', 'staff')->latest()->get();
            return view('admin.stafflist', compact('admins'));
        }
        return abort('403');
    }

    public function staff_store(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $validated =  Validator::make($request->all(), [
            'name' => ['string', 'required', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'sign_in_password' => ['required',new MatchOldPassword],
        ]);
        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        }

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role'     => 'staff',
            'isApproved' => true,
            'email_verified_at' => '2022-11-22 16:42:58',
        ]);

        return response()->json(['success' => 'Created Successfully.']);
    
      
    }

    public function staff_update(Request $request , User $admin){
        date_default_timezone_set('Asia/Manila');
        $validated =  Validator::make($request->all(), [
            'name' => ['string', 'required', 'max:255'],
            'sign_in_password' => ['required',new MatchOldPassword],
        ]);
        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        }

        User::find($admin->id)->update([
            'name' => $request->input('name'),
            'password' => Hash::make($request->input('password')),
        ]);

        return response()->json(['success' => 'Updated Successfully.']);
    
    }
}
