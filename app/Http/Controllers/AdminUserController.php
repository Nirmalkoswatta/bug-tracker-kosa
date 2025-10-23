<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    private function assertAdmin(): void
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'Admin') {
            abort(403);
        }
    }

    public function store(Request $request)
    {
        $this->assertAdmin();
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:QA,Dev,PM',
        ]);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => $data['role'],
        ]);
        return back()->with('success', $user->role . ' created successfully.');
    }

    public function destroy(int $id)
    {
        $this->assertAdmin();
        $auth = Auth::user();
        $user = User::findOrFail($id);
        if ($auth->id === $user->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        $user->delete();
        return back()->with('success', 'User deleted.');
    }
}
