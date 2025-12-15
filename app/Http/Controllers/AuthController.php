<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $response = Http::post(config('app.backend_url') . '/login', $request->only('email', 'password'));

        if ($response->successful()) {
            $data = $response->json();

            $token       = $data['token'] ?? null;
            $roles       = $data['roles'] ?? $data['role'] ?? [];
            $permissions = $data['permissions'] ?? [];
            $user        = $data['user'] ?? [];

            session([
                'api_token'        => $token,
                'user_role'        => is_array($roles) ? ($roles[0] ?? null) : $roles,
                'user_permissions' => $permissions,
                'user_data'        => $user,
            ]);

            return $token ? redirect()->route('dashboard') 
                          : back()->withErrors(['password' => 'Login gagal, periksa kembali email & password.']);
        }

        return back()->withErrors(['email' => 'Login gagal, periksa kembali email & password.']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name'            => 'required|string|max:100',
            'last_name'             => 'required|string|max:100',
            'email'                 => 'required|email',
            'birth_date'            => 'required|date',
            'gender'                => 'required|in:male,female',
            'password'              => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6',
        ]);

        $response = Http::post(config('app.backend_url') . '/register', $request->only([
            'first_name', 'last_name', 'email', 'birth_date', 'gender', 'password', 'password_confirmation'
        ]));

        return $response->successful() 
            ? redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.') 
            : back()->withErrors(['general' => 'Registrasi gagal, coba lagi.']);
    }

    public function logout(Request $request)
    {
        if ($token = Session::get('api_token')) {
            Http::withToken($token)->post(config('app.backend_url') . '/logout');
            Session::flush(); // clear all session
        }
        return redirect()->route('login');
    }

    // CRUD Admins
    public function list()
    {
        $response = Http::withToken(Session::get('api_token'))->get(config('app.backend_url') . '/admins');
        $admins = $response->successful() ? $response->json() : [];
        return view('admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admins.create');
    }

    public function store(Request $request)
    {
        Http::withToken(Session::get('api_token'))->post(config('app.backend_url') . '/admins', $request->all());
        return redirect()->route('admins.list');
    }

    public function edit($id)
    {
        $response = Http::withToken(Session::get('api_token'))->get(config('app.backend_url') . "/admins/$id");
        $admin = $response->successful() ? $response->json() : null;
        return view('admins.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        Http::withToken(Session::get('api_token'))->put(config('app.backend_url') . "/admins/$id", $request->all());
        return redirect()->route('admins.list');
    }

    public function destroy($id)
    {
        Http::withToken(Session::get('api_token'))->delete(config('app.backend_url') . "/admins/$id");
        return redirect()->route('admins.list');
    }
}
