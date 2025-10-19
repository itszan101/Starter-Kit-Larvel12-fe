<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    private $baseUrl = "http://127.0.0.1:8000/api/users";

    // Dashboard
    public function index()
    {
        return view('dashboard');
    }

    // List Admin
    public function list()
    {
        $token = Session::get('api_token');
        $response = Http::withToken($token)->get($this->baseUrl);

        if ($response->successful()) {
            $json = $response->json();
            $admins = $json['data'] ?? []; // ambil array di dalam key "data"
        } else {
            $admins = [];
        }

        return view('admins.index', ['admins' => $admins]);
    }


    // Show Create Form
    public function create()
    {
        return view('admins.create');
    }

    // Store Admin
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'birth_date' => 'required|date',
            'gender'    => 'required|in:male,female',
            'password'   => 'nullable|string|min:6',
            'password_confirmation' => 'nullable|string|min:6',
        ]);

        $token = Session::get('api_token');
        Http::withToken($token)->post("{$this->baseUrl}", $request->all());
        return redirect()->route('admins.list')->with('success', 'Admin berhasil ditambahkan.');
    }

    // Show Edit Form
    public function edit($id)
    {
        $token = Session::get('api_token');
        $response = Http::withToken($token)->get("{$this->baseUrl}/{$id}");

        if ($response->successful()) {
            $json = $response->json();
            $admin = $json['data'] ?? $json; // jaga-jaga kalau API balikin langsung data tunggal
        } else {
            return redirect()->route('admins.list')->withErrors(['error' => 'Gagal mengambil data admin.']);
        }

        return view('admins.edit', compact('admin'));
    }

    // Update Admin
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'email'      => 'nullable|email|max:255',
            'birth_date' => 'nullable|date',
            'gender'     => 'nullable|string',
            'password'   => 'nullable|string|min:6|confirmed',
            'password_confirmation' => 'nullable|string|min:6',
        ]);

        $token = Session::get('api_token');
        $response = Http::withToken($token)->put("{$this->baseUrl}/{$id}", $validated);
        if (!$response->successful()) {
            return back()->withErrors(['error' => 'Gagal memperbarui admin.']);
        }

        return redirect()->route('admins.list')->with('success', 'Admin berhasil diperbarui.');
    }

    // Delete Admin
    public function destroy($id)
    {
        $token = Session::get('api_token');
        Http::withToken($token)->delete("{$this->baseUrl}/$id");

        return redirect()->route('admins.list')->with('success', 'Admin berhasil dihapus.');
    }
}
