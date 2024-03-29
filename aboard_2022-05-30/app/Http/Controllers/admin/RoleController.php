<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

use Spatie\Permission\Models\Permission;


class RoleController extends Controller
{
    //
    public function index(){

        $roles = Role::all();

        return view('admin.roles.index', compact('roles'));

    }

    public function create(){
        return view('admin.roles.create');
    }

    public function store(Request $request){
        $validated = $request->validate(['name' => ['required', 'min:3']]);
        Role::create($validated);

        return  to_route('admin.roles.index');

    }

    public function edit(Role $role)
    {   $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }


    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|unique:permissions,name,'.$role->id
        ]);

        $role->update($validated);

        return redirect()->route('admin.roles.index')
            ->withSuccess(__('Role updated successfully.'));
    }



    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('admin.roles.index')
            ->withSuccess(__('Role deleted successfully.'));


    }

    public function givePermission (Request $request, Role $role ){

        if($role->hasPermissionTo($request->permission)){
            return back()->with('message', 'Permission exists.');
        }

        $role->givePermissionTo($request->permission);
        return back()->with('message', 'Permission added ');

    }

    public function revokePermission(Role $role, Permission $permission){
        if($role->hasPermissionTo($permission)){
            $role->RevokePermissionTo($permission);
            return back()->with('message', 'Permission revoked.');

        }

        return back()->with('message', 'Permission not exists.');
    }

}
