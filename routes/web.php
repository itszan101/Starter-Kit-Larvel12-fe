<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RolePermissionController;

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth
Route::middleware(['check.token:guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard
Route::middleware(['check.token:auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    // CRUD Admin
    Route::prefix('admins')->group(function () {
        Route::get('/', [AdminController::class, 'list'])->middleware('checkPermission:user.view')->name('admins.list');
        Route::get('/create', [AdminController::class, 'create'])->middleware('checkPermission:user.create')->name('admins.create');
        Route::post('/', [AdminController::class, 'store'])->middleware('checkPermission:user.create')->name('admins.store');
        Route::get('/{id}/edit', [AdminController::class, 'edit'])->middleware('checkPermission:user.update')->name('admins.edit');
        Route::put('/{id}', [AdminController::class, 'update'])->middleware('checkPermission:user.update')->name('admins.update');
        Route::delete('/{id}', [AdminController::class, 'destroy'])->middleware('checkPermission:user.delete')->name('admins.destroy');
        Route::put('/{id}/assign-role', [RolePermissionController::class, 'assignRole'])->middleware('checkPermission:role.assignUser')->name('admins.assign-role');
        Route::get('/{id}/download-sk', [AdminController::class, 'downloadSk'])->name('admins.download-sk');
    });
    // Role & Permissions
    Route::prefix('roles')->group(function () {
        Route::get('/', [RolePermissionController::class, 'listRoles'])->middleware('checkPermission:role.view')->name('list.roles');
        Route::post('/', [RolePermissionController::class, 'storeRole'])->middleware('checkPermission:role.create')->name('roles.store');
        Route::delete('/{id}', [RolePermissionController::class, 'deleteRole'])->middleware('checkPermission:role.delete')->name('roles.delete');
        Route::post('/update-permissions', [RolePermissionController::class, 'updateRolePermissions'])->middleware('checkPermission:permission.assignRole')->name('roles.update.permissions');
    });
    // Permissions
    Route::prefix('permissions')->group(function () {
        route::get('/', [RolePermissionController::class, 'listPermissions'])->middleware('checkPermission:permission.view')->name('list.permissions');
        Route::post('/', [RolePermissionController::class, 'storePermission'])->middleware('checkPermission:permission.create')->name('permissions.store');
        Route::delete('/{id}', [RolePermissionController::class, 'deletePermission'])->middleware('checkPermission:permission.delete')->name('permissions.delete');
        Route::post('/assign', [RolePermissionController::class, 'assignPermissionToRole'])->middleware('checkPermission:permission.assignRole')->name('permissions.assign');
    });
    Route::get('/test', function () {
        return view('admins.indexx');
    })->name('test');
});

Route::get('/test-tts', function () {
    return view('tts');
})->name('test-tts');
