<?php

namespace App\Http\Controllers\Role;


use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('read-role');
        // Fetch all roles with thier permissions
        $roles = \Spatie\Permission\Models\Role::with('permissions')->get();
        // Pass roles and permissions to the view
        return view('pages.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create-role');
        // Fetch all permissions
        $permissions = \Spatie\Permission\Models\Permission::all();
        // Pass permissions to the view
        return view('pages.role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'required|array',
        ], [
            'name.required' => 'This field is required',
            'permissions.required' => 'This field is required',
        ]);
        Gate::authorize('create-role');

        DB::beginTransaction();
        try {
            // Create a new role
            $role = \Spatie\Permission\Models\Role::create(['name' => $request->name]);
            // Assign permissions to the role
            $role->syncPermissions($request->permissions);
            DB::commit();
            return redirect()->route('roles.index')->with('success', 'Role created successfully');
        } catch (\Exception $e) {
            //log the error
            Log::error('Role creation failed: ' . $e->getMessage());
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to create role');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        Gate::authorize('update-role');
        // Fetch all permissions
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        return view('pages.role.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        Gate::authorize('update-role');

        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'array|exists:permissions,name'
        ]);

        DB::beginTransaction();
        try {
            $role->update(['name' => $request->name]);
            $role->syncPermissions($request->permissions ?? []);
            DB::commit();
            return redirect()->route('roles.index')->with('success', 'Role updated successfully');
        } catch (\Exception $e) {
            //log the error
            Log::error('Role update failed: ' . $e->getMessage());
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to update role');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        Gate::authorize('delete-role');
        DB::beginTransaction();
        try {
            $role->delete();
            DB::commit();
            return redirect()->route('roles.index')->with('error', 'Role Deleted');
        } catch (\Exception $e) {
            //log the error
            Log::error('Role deletion failed: ' . $e->getMessage());
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to delete role');
        }
    }
 
}
