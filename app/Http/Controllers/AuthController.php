<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    private $baseUrl = "http://127.0.0.1:8000/api";

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

        // Kirim ke API login (ubah sesuai endpoint API kamu)
        $response = Http::post("{$this->baseUrl}/login", [
            'email'    => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            $data  = $response->json();
            $token = $data['token'] ?? null;
            $role = $data['role'][0] ?? null;

            if ($token) {
                // simpan token di session
                session([
                    'api_token' => $token,
                    'user_role' => $role
                ]);

                return redirect()->route('dashboard');
            }

            return back()->withErrors(['password' => 'Login gagal, periksa kembali email & password.']);
        }

        return back()->withErrors(['email' => 'Login gagal, periksa kembali email & password.']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'     => 'required|email',
            'birth_date' => 'required|date',
            'gender'    => 'required|in:male,female',
            'password'  => 'required|string|min:6|confirmed',
            'password_confirmation'  => 'required|string|min:6',
        ]);

        $response = Http::post("{$this->baseUrl}/register", [
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'     => $request->email,
            'birth_date' => $request->birth_date,
            'gender'    => $request->gender, // sesuai Postman: "Laki-laki" / "Perempuan"
            'password'  => $request->password,
            'password_confirmation' => $request->password_confirmation,
        ]);
        if ($response->successful()) {
            return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
        }

        return back()->withErrors(['general' => 'Registrasi gagal, coba lagi.']);
    }

    public function logout(Request $request)
    {
        $token = Session::get('api_token');

        if ($token) {
            // Kirim request logout ke backend API
            $response = Http::withToken($token)->post("{$this->baseUrl}/logout");

            // Opsional: Cek jika berhasil
            if ($response->successful()) {
                Session::forget('api_token');
            }
        }
        return redirect()->route('login');
    }

    public function list()
    {
        $token = Session::get('token');
        $response = Http::withToken($token)->get($this->baseUrl);
        $admins = $response->successful() ? $response->json() : [];
        return view('admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admins.create');
    }

    public function store(Request $request)
    {
        $token = Session::get('token');
        Http::post("{$this->baseUrl}/register", $request->all());
        // dd($request->all());
        return redirect()->route('admins.list');
    }

    public function edit($id)
    {
        $token = Session::get('token');
        $response = Http::withToken($token)->get("{$this->baseUrl}/$id");
        // dd($response->json());
        $admin = $response->successful() ? $response->json() : null;
        return view('admins.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $token = Session::get('token');
        Http::withToken($token)->put("{$this->baseUrl}/$id", $request->all());
        // dd($request->all());
        return redirect()->route('admins.list');
    }

    public function destroy($id)
    {
        $token = Session::get('token');
        Http::withToken($token)->post("{$this->baseUrl}/logout");
        return redirect()->route('admins.list');
    }
}
