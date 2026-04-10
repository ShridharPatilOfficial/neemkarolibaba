<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = AdminUser::orderBy('name')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.form', ['adminUser' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'                  => ['required', 'string', 'max:100'],
            'email'                 => ['required', 'email', 'unique:admin_users,email'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
        ]);

        AdminUser::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Admin user created.');
    }

    public function edit(AdminUser $user)
    {
        return view('admin.users.form', ['adminUser' => $user]);
    }

    public function update(Request $request, AdminUser $user)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'unique:admin_users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Admin user updated.');
    }

    public function destroy(AdminUser $user)
    {
        if ($user->id === auth('admin')->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        $user->delete();
        return back()->with('success', 'User deleted.');
    }
}
