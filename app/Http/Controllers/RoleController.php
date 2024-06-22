<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:delete role', ['only' => ['destroy']]);
        $this->middleware('permission:update role', ['only' => ['update', 'edit']]);
        $this->middleware('permission:view role', ['only' => ['index']]);
        $this->middleware('permission:create role', ['only' => ['create', 'store', 'addPermissionsToRole', 'updatePermissionsToRole']]);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $roles = Role::query()
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'LIKE', '%'.$search.'%')
                    ->orWhere('id', $search); 
            })
            ->get();
        return view('role-permission.role.index', compact('roles', 'search'));
    }
    

    public function create()
    {
        return view('role-permission.role.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:roles,name'
            ]
        ]);

        Role::create([
            'name' => $request->name
        ]);

        return redirect('roles')->with('status', 'Role Created Successfully');
    }


    public function edit(Role $role)
    {
        return view('role-permission.role.edit', [
            'role' => $role
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:roles,name,' . $role->id
            ]
        ]);
        $role->update([
            'name' => $request->name
        ]);

        return redirect('roles')->with('status', 'Role Updated Successfully');
    }

    public function destroy($roleId)
    {
        $role = Role::find($roleId);
        $role->delete();
        return redirect('roles')->with('status', 'Role Deleted Successfully');
    }

    public function addPermissionsToRole($roleId)
    {
        $permissions = Permission::get();
        $role = Role::findOrFail($roleId);

        $rolePermission = DB::table('role_has_permissions')
            ->where('role_has_permissions.role_id', $role->id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('role-permission.role.add-permissions', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermission' => $rolePermission
        ]);
    }

    public function updatePermissionsToRole(Request $request, $roleId)
    {
        $request->validate([
            'permissions' => 'required',
        ]);

        $role = Role::findOrFail($roleId);
        $role->syncPermissions($request->permissions);

        return redirect()->back()->with('status', 'Permissions updated successfully');
    }

}
