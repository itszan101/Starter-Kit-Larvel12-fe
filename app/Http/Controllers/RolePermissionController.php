<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class RolePermissionController extends Controller
{
    private $rolesUrl = "https://starter-kit-larvel12.vercel.app/api/api/roles";
    // private $rolesUrl = "http://127.0.0.1:8000/api/roles";
    private $permissionsUrl = "https://starter-kit-larvel12.vercel.app/api/api/permissions";
    // private $permissionsUrl = "http://127.0.0.1:8000/api/permissions";
    private $userUrl = "https://starter-kit-larvel12.vercel.app/api/api/users";
    // private $userUrl = "http://127.0.0.1:8000/api/users";

    // List roles
    public function listRoles()
    {
        $token = Session::get('api_token');

        // Ambil daftar role
        $rolesResponse = Http::withHeaders(['Accept' => 'application/json'])
            ->withToken($token)
            ->get($this->rolesUrl);

        $roles = $rolesResponse->successful()
            ? ($rolesResponse->json()['roles'] ?? $rolesResponse->json()['data'] ?? [])
            : [];

        // Ambil daftar role dan permission mapping
        $permissionsResponse = Http::withHeaders(['Accept' => 'application/json'])
            ->withToken($token)
            ->get("{$this->rolesUrl}/manager/permissions");

        $rolePermissions = $permissionsResponse->successful()
            ? ($permissionsResponse->json()['roles'] ?? $permissionsResponse->json()['data'] ?? [])
            : [];

        // Ambil semua daftar permission (endpoint backend)
        $allPermissionsResponse = Http::withHeaders(['Accept' => 'application/json'])
            ->withToken($token)
            ->get($this->permissionsUrl);
        $permissions = $allPermissionsResponse->successful()
            ? ($allPermissionsResponse->json()['permissions'] ?? $allPermissionsResponse->json()['data'] ?? $allPermissionsResponse->json())
            : [];

        // Ambil daftar user
        $usersResponse = Http::withHeaders(['Accept' => 'application/json'])
            ->withToken($token)
            ->get($this->userUrl);

        $users = $usersResponse->successful()
            ? $usersResponse->json()
            : [];

        return view('RolePermission.roleIndex', compact('roles', 'rolePermissions', 'permissions', 'users'));
    }

    // Store role
    public function storeRole(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100']);

        $token = Session::get('api_token');

        try {
            $response = Http::withHeaders(['Accept' => 'application/json'])
                ->withToken($token)
                ->post($this->rolesUrl, ['name' => $request->name]);

            $json = $response->json();

            return match ($response->status()) {
                201, 200 => redirect()->route('list.roles')
                    ->with('success', 'Role berhasil ditambahkan!'),

                422 => redirect()->route('list.roles')
                    ->withInput()
                    ->with('error', $json['errors']['name'][0] ?? $json['message'] ?? 'Validasi gagal.'),

                default => redirect()->route('list.roles')
                    ->withInput()
                    ->with('error', $json['message'] ?? 'Gagal menambahkan role.')
            };
        } catch (\Throwable $e) {
            return redirect()->route('list.roles')
                ->with('error', 'Gagal terhubung ke server: ' . $e->getMessage());
        }
    }

    // Delete Role
    public function deleteRole(Request $request, $id)
    {
        $token = Session::get('api_token');

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])
                ->withToken($token)
                ->delete("{$this->rolesUrl}/{$id}");

            $json = $response->json();
            $message = $json['message'] ?? 'Terjadi kesalahan saat menghapus role.';
            // Jika sukses (200 OK)
            if ($response->successful()) {
                return redirect()
                    ->route('list.roles')
                    ->with('success', $message ?? 'Role berhasil dihapus!');
            }
            // Jika status lain (422, 500, dll)
            return redirect()
                ->route('list.roles')
                ->with('error', $message);
        } catch (\Throwable $e) {
            return redirect()
                ->route('list.roles')
                ->with('error', 'Gagal terhubung ke server: ' . $e->getMessage());
        }
    }

    // List permissions
    public function listPermissions()
    {
        $token = Session::get('api_token');

        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->withToken($token)->get($this->permissionsUrl);

        $permissions = $response->successful()
            ? ($response->json()['permissions'] ?? $response->json()['data'] ?? [])
            : [];

        // Ambil daftar role juga
        $rolesResponse = Http::withHeaders([
            'Accept' => 'application/json',
        ])->withToken($token)->get($this->rolesUrl);

        $roles = $rolesResponse->successful()
            ? ($rolesResponse->json()['roles'] ?? $rolesResponse->json()['data'] ?? [])
            : [];

        return view('RolePermission.permissionIndex', compact('permissions', 'roles'));
    }

    // Store permission
    public function storePermission(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $token = Session::get('api_token');

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->withToken($token)
                ->post($this->permissionsUrl, [
                    'name' => $request->name,
                ]);

            if ($response->successful()) {
                return redirect()
                    ->route('list.permissions')
                    ->with('success', $response->json()['message'] ?? 'Permission berhasil dibuat!');
            }

            if ($response->status() === 422) {
                $json = $response->json();
                $error = $json['errors']['name'][0] ?? $json['message'] ?? 'Validasi gagal.';
                return redirect()
                    ->route('list.permissions')
                    ->withInput()
                    ->with('error', $error);
            }

            $json = $response->json();
            $message = $json['message'] ?? 'Gagal menambahkan permission.';
            return redirect()
                ->route('list.permissions')
                ->with('error', $message);
        } catch (\Throwable $e) {
            return redirect()
                ->route('list.permissions')
                ->with('error', 'Gagal terhubung ke server: ' . $e->getMessage());
        }
    }

    // Delete permission
    public function deletePermission($id)
    {
        $token = Session::get('api_token');

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->withToken($token)
                ->delete("{$this->permissionsUrl}/{$id}");

            if ($response->successful()) {
                return redirect()
                    ->route('list.permissions')
                    ->with('success', $response->json()['message'] ?? 'Permission berhasil dihapus!');
            }

            // Tangkap pesan error jika sedang digunakan oleh role
            $json = $response->json();
            $message = $json['message'] ?? 'Gagal menghapus permission.';
            return redirect()
                ->route('list.permissions')
                ->with('error', $message);
        } catch (\Throwable $e) {
            return redirect()
                ->route('list.permissions')
                ->with('error', 'Gagal terhubung ke server: ' . $e->getMessage());
        }
    }

    // Assign permission to role
    public function assignPermissionToRole(Request $request)
    {
        $request->validate([
            'role_id' => 'required',
            'permissions' => 'required|array|min:1',
        ]);

        $token = Session::get('api_token');

        try {
            // Ambil semua role untuk menemukan nama role dari ID
            $rolesResponse = Http::withHeaders([
                'Accept' => 'application/json',
            ])->withToken($token)
                ->get($this->rolesUrl);

            if (!$rolesResponse->successful()) {
                return redirect()->route('list.permissions')
                    ->with('error', 'Gagal memuat daftar role.');
            }

            $rolesData = $rolesResponse->json()['roles'] ?? $rolesResponse->json()['data'] ?? [];
            $selectedRole = collect($rolesData)->firstWhere('id', (int)$request->role_id);

            if (!$selectedRole || !isset($selectedRole['name'])) {
                return redirect()->route('list.permissions')
                    ->with('error', 'Role tidak ditemukan.');
            }

            $roleName = $selectedRole['name'];

            // Kirim ke API backend untuk assign permission
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->withToken($token)
                ->post("{$this->rolesUrl}/{$roleName}/assign-permission", [
                    'permissions' => $request->permissions,
                ]);

            if ($response->successful()) {
                return redirect()
                    ->route('list.permissions')
                    ->with('success', $response->json()['message'] ?? 'Permission berhasil di-assign ke role!');
            }

            $message = $response->json()['message'] ?? 'Gagal assign permission ke role.';
            return redirect()->route('list.permissions')->with('error', $message);
        } catch (\Throwable $e) {
            return redirect()
                ->route('list.permissions')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Update permission role
    public function updateRolePermissions(Request $request)
    {
        $request->validate([
            'role_name' => 'required|string',
            'permissions' => 'array'
        ]);

        $token = Session::get('api_token');
        $roleName = $request->role_name;

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->withToken($token)
                ->post("{$this->rolesUrl}/{$roleName}/permissions/update", [
                    'permissions' => $request->permissions ?? []
                ]);

            if ($response->successful()) {
                return redirect()->route('list.roles')
                    ->with('success', $response->json()['message'] ?? 'Permissions berhasil diperbarui!');
            }

            return redirect()->route('list.roles')
                ->with('error', $response->json()['message'] ?? 'Gagal memperbarui permissions.');
        } catch (\Throwable $e) {
            return redirect()->route('list.roles')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Assign role
    public function assignRole(Request $request, $id)
    {
        $token = Session::get('api_token');
        // dd($request->input('roles', []));
        $response = Http::withToken($token)
            ->accept('application/json')
            ->post("{$this->userUrl}/{$id}/roles/update", [
                'roles' => $request->input('roles', [])
            ]);

        if ($response->successful()) {
            $data = $response->json();
            return redirect()->route('admins.list')->with('success', $data['message'] ?? 'Role berhasil diperbarui.');
        } else {
            $errorMessage = $response->json('message') ?? 'Gagal memperbarui role.';
            return redirect()->route('admins.list')->with('error', $errorMessage);
        }
    }
}
