<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $request->file('profile_picture')
            ? $request->file('profile_picture')->store('profile_pictures', 'public')
            : 'profile_pictures/default.jpg';

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_picture' => $path,
        ]);

        return redirect()->route('login')->with('success', 'Registration successful!');
    }

    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember_token'); // Periksa apakah "Remember Me" dicentang

        if (Auth::attempt($credentials, $remember)) {
            // Redirect ke halaman yang diinginkan setelah login berhasil
            return redirect()->route('tasks.index');
        }

        // Jika login gagal
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
