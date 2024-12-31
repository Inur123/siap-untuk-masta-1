<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Operator\OperatorController;
use App\Http\Controllers\Mahasiswa\MahasiswaController;
Auth::routes();

// Home route for redirection after login
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/home', [HomeController::class, 'index'])->name('home');
// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'showAllUsers'])->name('admin.users');
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.edit'); // Edit user route
    Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.update'); // Update user route
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.destroy'); // Delete user route
    Route::get('/admin/assign-groups', [AdminController::class, 'assignGroups'])->name('admin.assign.groups');
    Route::get('/admin/clear-groups', [AdminController::class, 'clearGroups'])->name('admin.clearGroups');
    Route::delete('/admin/mahasiswa/clear', [AdminController::class, 'clearMahasiswa'])->name('admin.mahasiswa.clear');
    //operator
    Route::get('admin/operators/create', [AdminController::class, 'createOperator'])->name('admin.create_operator');
    // Route to store the new operator
    Route::post('admin/operators', [AdminController::class, 'storeOperator'])->name('admin.store_operator');

    Route::get('/admin/operator/{id}/edit', [AdminController::class, 'editOperator'])->name('admin.edit_operator');

    Route::put('/admin/operator/{id}', [AdminController::class, 'updateOperator'])->name('admin.update_operator');
    Route::delete('admin/operator/{id}', [AdminController::class, 'destroyOperator'])->name('admin.operator.destroy');
    Route::get('admin/operators', [AdminController::class, 'showOperators'])->name('admin.operators');
    Route::get('admin/mahasiswa', [AdminController::class, 'showMahasiswa'])->name('admin.mahasiswa');

    //kelompok
    Route::get('/admin/groups', [AdminController::class, 'showGroups'])->name('admin.groups');
    // Announcement Routes
// Route to view all announcements
// Route to create a new announcement
    Route::get('/admin/create-announcement', [AdminController::class, 'createAnnouncement'])->name('admin.create_announcement');
    Route::post('/admin/store-announcement', [AdminController::class, 'storeAnnouncement'])->name('admin.store_announcement'); // Route to store the new announcement
    Route::put('/admin/announcement/{id}/toggle', [AdminController::class, 'toggleAnnouncementStatus'])->name('admin.toggle_announcement_status'); // Route to toggle status of announcement
    Route::put('/admin/announcement/{id}/toggle', [AdminController::class, 'toggleAnnouncementStatus'])->name('admin.toggle_announcement_status');
    Route::delete('/admin/announcement/{id}', [AdminController::class, 'destroyAnnouncement'])->name('admin.destroy_announcement'); // Route to delete the announcement
    Route::put('/admin/announcement/{id}/update', [AdminController::class, 'updateAnnouncement'])->name('admin.update_announcement');
    //gruop
    Route::get('/admin/group/{kelompok}', [AdminController::class, 'showGroupDetail'])->name('admin.groupDetail');
    Route::get('/admin/export-users', [AdminController::class, 'exportUsersToExcel'])->name('admin.exportUsers');
    Route::get('/admin/group/{kelompok}/export', [AdminController::class, 'exportGroupMembersToExcel'])->name('admin.exportGroupMembers');

    Route::get('/admin/export-group-{kelompok}-to-word', [AdminController::class, 'exportGroupMembersToWord'])->name('admin.exportGroupMembersToWord');
Route::get('/admin/export-users-to-word', [AdminController::class, 'exportUsersToWord'])->name('admin.exportUsersToWord');
});

// Operator routes
Route::middleware('auth')->group(function () {
    Route::get('/operator/dashboard', [OperatorController::class, 'dashboard'])->name('operator.dashboard');
    Route::get('operator/export-excel', [OperatorController::class, 'exportExcel'])->name('operator.exportExcel');
    Route::get('operator/export-word', [OperatorController::class, 'exportWord'])->name('operator.exportWord');
    Route::get('/dashboard', [AdminController::class, 'getAnnouncementsByRole'])->name('dashboard');
});

// Mahasiswa routes
Route::middleware('auth')->group(function () {
    Route::get('/mahasiswa/dashboard', [MahasiswaController::class, 'dashboard'])->name('mahasiswa.dashboard');
    Route::get('mahasiswa/edit/{encryptedId}', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
    Route::put('mahasiswa/update', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
    Route::get('/dashboard', [AdminController::class, 'getAnnouncementsByRole'])->name('dashboard');
});

