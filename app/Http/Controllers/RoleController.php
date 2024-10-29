<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array'
        ]);
    
        $role = Role::create(['name' => $request->name]);
    
        // Sync permissions using names
        $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name');
        $role->syncPermissions($permissionNames);
    
        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
{
    $request->validate([
        'name' => 'required|unique:roles,name,' . $role->id,
        'permissions' => 'array'
    ]);

    $role->update(['name' => $request->name]);

    // Sync permissions using names
    $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name');
    $role->syncPermissions($permissionNames);

    return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
}

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
