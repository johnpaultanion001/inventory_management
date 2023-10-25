<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use Validator;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class RolesController extends Controller
{

    public function index()
    {
        $roles = Role::where('isRemove', 0)->latest()->get();
        return view('admin.roles.roles', compact('roles'));
    }


    public function create()
    {
        $permissions = Permission::all()->pluck('title', 'id');
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        $role = Role::create($request->all());
        $role->permissions()->sync($request->input('permissions', []));
        Activity::create([
            'activity' => 'Created account',
            'user_id' => Auth::user()->id
        ]);
        return redirect()->route('admin.roles.index');
    }

    public function edit(Role $role)
    {

        $permissions = Permission::all()->pluck('title', 'id');
        $role->load('permissions');
        return view('admin.roles.edit', compact('permissions', 'role'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->all());
        $role->permissions()->sync($request->input('permissions', []));
        Activity::create([
            'activity' => 'Upadated role',
            'user_id' => Auth::user()->id
        ]);
        return redirect()->route('admin.roles.index');
    }

}
