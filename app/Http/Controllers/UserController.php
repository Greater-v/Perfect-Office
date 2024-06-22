<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:delete user', ['only' => ['destroy']]);
        $this->middleware('permission:update user', ['only' => ['update', 'edit']]);
        $this->middleware('permission:view user',   ['only' => ['index']]);
        $this->middleware('permission:create user', ['only' => ['create', 'store']]);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $users = User::query()
                    ->when($search, function ($query) use ($search) {
                        $query->where('name', 'LIKE', '%'.$search.'%')
                              ->orWhere('id', $search)
                              ->orWhere('email', 'LIKE', '%'.$search.'%');
                    })
                    ->paginate(5);
    
        return view('role-permission.user.index', compact('users', 'search'));
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        $permissions = Permission::pluck('name', 'name')->all();
        return view('role-permission.user.create', [
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:20',
            'roles' => 'required',
            'permissions' => 'required'

        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->syncRoles($request->roles);
        $user->syncPermissions($request->permissions);

        return redirect('/users')->with('status', 'User Created Successfully With Roles');
    }

    public function edit(User $user)
    {

        $roles = Role::pluck('name', 'name')->all();
        $permissions = Permission::pluck('name', 'name')->all();
        $userRoles = $user->roles->pluck('name', 'name')->all();
        $userPermissions = $user->permissions->pluck('name', 'name')->all();

        return view('role-permission.user.edit', [
            'user' => $user,
            'roles' => $roles,
            'permissions' => $permissions,
            'userRoles' => $userRoles,
            'userPermissions' => $userPermissions,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|max:20',
            'roles' => 'required',
            'permissions' => 'required'

        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        $user->syncRoles($request->roles);
        $user->syncPermissions($request->permissions);

        return redirect('/users')->with('status', 'User Updated Successfully With Roles');
    }

    public function destroy($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        return redirect('/users')->with('status', 'User Deleted Successfully');
    }
}