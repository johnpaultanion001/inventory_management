<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Activity;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{

    public function defaultPassowrd(User $user)
    {
        User::find($user->id)->update([
            'password' => '$2y$10$zPiaTbYwkxYcejFmEimhWedeAogTJvEb/yGmBVx390ihhPFy8r896' , //password,
        ]);
        return response()->json(['success' => 'Updated Successfully.']);
    }


    public function create()
    {
        $roles = Role::all()->pluck('title', 'id');
        return view('admin.accounts.create', compact('roles'));
    }

    public function edit(User $account)
    {
        $roles = Role::all()->pluck('title', 'id');
        $account->load('roles');
        return view('admin.accounts.edit', compact('roles', 'account'));
    }

    public function index(){
        $accounts = User::latest()->get();
        return view('admin.accounts.accounts', compact('accounts'));

    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));

        Activity::create([
            'activity' => 'Created account',
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('admin.accounts.index');
    }

    public function update(UpdateUserRequest $request, User $account)
    {
        $account->update($request->all());
        $account->roles()->sync($request->input('roles', []));
        Activity::create([
            'activity' => 'Upadated account',
            'user_id' => Auth::user()->id
        ]);
        return redirect()->route('admin.accounts.index');
    }
}
