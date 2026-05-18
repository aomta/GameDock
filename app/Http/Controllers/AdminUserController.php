<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', ['users' => $users]);
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate(['role' => 'required|in:admin,user']);
        $user->role = $request->input('role');
        $user->save();
        return redirect()->route('admin.users.index')->with('status', 'User updated');
    }
}
