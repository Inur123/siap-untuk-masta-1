<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\Operator\OperatorController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Mahasiswa\MahasiswaController;
Auth::routes();

// Menambahkan route untuk auth (termasuk reset password)
Auth::routes(['reset' => true]);

// Menampilkan form permintaan reset password
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

// Mengirimkan link reset password ke email pengguna
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Menampilkan form untuk mengatur ulang password
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

// Menangani permintaan reset password
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');


// Home route for redirection after login
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/home', [HomeController::class, 'index'])->name('home');
// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::resource('kegiatan', KegiatanController::class);
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
    Route::get('/admin/groups', [AdminController::class, 'showGroups'])->name('admin.groups');
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

    // sertifikat




});

// GET route to show the form for generating certificate
Route::middleware(['auth', 'role:admin'])->get('/generate-certificate-admin', function () {
    return view('generate-certificate-admin'); // Return the view with the form
});

// POST route to handle form submission for generating the certificate
Route::middleware(['auth', 'role:admin'])->post('/generate-certificate-admin', [CertificateController::class, 'generateForAdmin']);


// Operator routes
Route::middleware(['auth', 'role:operator'])->group(function () {
    Route::get('/operator/dashboard', [OperatorController::class, 'dashboard'])->name('operator.dashboard');
    Route::get('operator/export-excel', [OperatorController::class, 'exportExcel'])->name('operator.exportExcel');
    Route::get('operator/export-word', [OperatorController::class, 'exportWord'])->name('operator.exportWord');
    Route::get('/operator/absensi', [OperatorController::class, 'index'])->name('operator.absensi');
    Route::get('operator/absensi', [OperatorController::class, 'absensi'])->name('operator.absensi');
    Route::get('/operator/absensi/{kegiatanId}/detail', [OperatorController::class, 'detailAbsensi'])->name('operator.absensi.detail');



});

// Mahasiswa routes
Route::middleware('auth')->group(function () {
    Route::get('/mahasiswa/dashboard', [MahasiswaController::class, 'dashboard'])->name('mahasiswa.dashboard');
    Route::get('mahasiswa/edit/{encryptedId}', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
    Route::put('mahasiswa/update', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
    Route::get('/dashboard', [AdminController::class, 'getAnnouncementsByRole'])->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    // Route untuk absensi

    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::get('/absensi/create/{kegiatan_id}', [AbsensiController::class, 'create'])->name('absensi.create');
    Route::post('/absensi/store/{kegiatan_id}', [AbsensiController::class, 'store'])->name('absensi.store');
    Route::get('/absensi/show/{id}', [AbsensiController::class, 'show'])->name('absensi.show');
    Route::delete('/absensi/{id}', [AbsensiController::class, 'destroy'])->name('absensi.destroy');
    Route::post('/absensi/store/{kegiatan_id}', [AbsensiController::class, 'store'])->name('absensi.store');
    Route::get('/absensi/select/{kegiatan_id}', [AbsensiController::class, 'selectUsers'])->name('absensi.select');


    Route::get('/absensi/scan/{user_id}', [AbsensiController::class, 'scan'])
    ->name('absensi.scan');
    Route::post('/mark-attendance', [AbsensiController::class, 'markAttendance']);

Route::post('/absensi/mark-attendance', [AbsensiController::class, 'markAttendance'])->name('absensi.markAttendance');

});

Route::middleware(['auth'])->group(function () {
    Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index');
    Route::get('/kegiatan/create', [KegiatanController::class, 'create'])->name('kegiatan.create'); // Halaman tambah kegiatan
    Route::post('/kegiatan/store', [KegiatanController::class, 'store'])->name('kegiatan.store');

    Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index');

// Route untuk halaman scan berdasarkan kegiatan
Route::get('/scan/{kegiatan}', [AbsensiController::class, 'scan'])->name('absensi.scan');
Route::post('/absensi/store/{qr_code}', [AbsensiController::class, 'store'])->name('absensi.store');



Route::get('/scan/{kegiatan}', [AbsensiController::class, 'scan'])->name('scan');

Route::post('/absensi/validasi', [AbsensiController::class, 'validasiQr'])->name('absensi.validasi');
Route::post('/absensi/proses', [AbsensiController::class, 'proses'])->name('absensi.proses');
Route::get('absensi/scan', [AbsensiController::class, 'scan'])->name('absensi.scan');
Route::post('absensi/validasi', [AbsensiController::class, 'validasiQr'])->name('absensi.validasi');
Route::post('absensi/proses', [AbsensiController::class, 'prosesAbsensi'])->name('absensi.proses');
});

// Remove the second occurrence of the route definition for '/absensi/validasi-qr'
Route::middleware(['auth', 'role:admin,operator'])->group(function () {
    Route::resource('absensi', AbsensiController::class)->only(['index', 'create', 'store', 'destroy']);

    // Change 'show' route to 'groups'
    Route::get('/absensi/{kegiatan_id}/kelompok/{kelompok_id}', [AbsensiController::class, 'groups'])->name('absensi.groups');

    Route::get('/absensi/select/{kegiatan_id}', [AbsensiController::class, 'selectUsers'])->name('absensi.select');
    Route::post('/validasi-qr', [AbsensiController::class, 'validasiQr'])->name('validasi-qr');

    Route::get('/absensi/scan/{kegiatan_id}', [AbsensiController::class, 'scan'])->name('absensi.scan');
    Route::post('/absensi/mark-attendance', [AbsensiController::class, 'markAttendance'])->name('absensi.markAttendance');
    Route::post('/proses-absensi', [AbsensiController::class, 'prosesAbsensi'])->name('proses-absensi');
    Route::get('/absensi/{kegiatan_id}/kelompok/{kelompok_id}/details', [AbsensiController::class, 'groups'])->name('absensi.groups');
    Route::get('/absensi/{kegiatan_id}/kelompok/{kelompok_id}/details', [AbsensiController::class, 'groupDetail'])->name('absensi.groups.detail');

    Route::get('/absensi/groups/{kegiatanId}/{kelompokId}', [AbsensiController::class, 'groups'])->name('absensi.groups');
    Route::get('/absensi/detail/{kegiatanId}', [AbsensiController::class, 'showDetail'])->name('absensi.detail');

    Route::get('kegiatan/{kegiatanId}/groups', [AbsensiController::class, 'showGroups'])->name('absensi.groups');

    Route::post('absensi/{kegiatanId}/update', [AbsensiController::class, 'updateStatus'])->name('absensi.updateStatus');
    Route::post('/absensi/{kegiatanId}/{userId}/update', [AbsensiController::class, 'updateStatus'])->name('absensi.updateStatus');
    Route::post('/absensi/{kegiatanId}/{userId}/update', [AbsensiController::class, 'update'])->name('absensi.update');
    Route::post('/absensi/{kegiatan_id}/{user_id}/update', [AbsensiController::class, 'updateAbsensi']);

    Route::post('/absensi/{kegiatanId}/{userId}/update', [AbsensiController::class, 'update']);
    Route::get('/absensi/{id}/card', [AbsensiController::class, 'showCard'])->name('absensi.card');
    Route::get('/card', [AbsensiController::class, 'card'])->name('absensi.card');
    Route::get('absensi/{kegiatanId}/group/{kelompokId}', [AbsensiController::class, 'showGroupDetail'])->name('absensi.group.detail');

    Route::get('/export-absensi', [KegiatanController::class, 'exportAbsensi'])->name('export.absensi');
    Route::get('operator/absensi/export/{kegiatan_id}/{kelompok}', [AbsensiController::class, 'exportAbsensi'])->name('operator.absensi.export');

    Route::get('/sertifikat/preview', [CertificateController::class, 'showPreview'])->name('sertifikat.preview');
    Route::get('/sertifikat/generate', [CertificateController::class, 'generate'])->name('sertifikat.generate');
    Route::get('/sertifikat/download/{id}', [CertificateController::class, 'download'])->name('sertifikat.download');

});

Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('mahasiswa/absensi', [MahasiswaController::class, 'absensi'])->name('mahasiswa.absensi');
});

Route::middleware('auth')->get('/sertifikat/preview', [CertificateController::class, 'showPreview'])->name('sertifikat.preview');
Route::middleware('auth')->get('/sertifikat/generate', [CertificateController::class, 'generate'])->name('sertifikat.generate');
Route::middleware('auth')->get('/sertifikat/download/{id}', [CertificateController::class, 'download'])->name('sertifikat.download');



