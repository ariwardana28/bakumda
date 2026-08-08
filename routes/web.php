<?php

use App\Http\Controllers\Admin\AnggotaCardController;
use App\Http\Controllers\Admin\AnggotaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserAnggotaController;
use App\Http\Controllers\Admin\PelatihanController;
use App\Http\Controllers\Admin\MateriController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\UserPelatihanController;
use App\Http\Controllers\Admin\PelatihanAnggotaController;
use App\Http\Controllers\UserSoalController;
use App\Http\Controllers\HalamanUtamaController;
use App\Http\Controllers\UserMateriController;
use App\Http\Controllers\Admin\SoalController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HalamanUtamaController::class, 'index'])->name('welcome');

// Route::get('/sertifikasi', function () {
//     return view('admin.sertifikasi.index');
// });

// Route::get('/sertifikasi/formulir', function () {
//     return view('admin.sertifikasi.create');
// });

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/anggota/{card_id}', [DashboardController::class, 'anggota'])->name('public.anggota.show');
Route::post('/notifications/read-all', [DashboardController::class, 'markAllNotificationsAsRead'])->name('notifications.readAll');
Route::get('/notifications/{id}/read', [DashboardController::class, 'readNotification'])->name('notifications.read');

/*
|--------------------------------------------------------------------------
| API Wilayah Routes
|--------------------------------------------------------------------------
*/

Route::prefix('api/wilayah')->group(function () {
    Route::get('/provinces', [WilayahController::class, 'provinces']);
    Route::get('/regencies/{id}', [WilayahController::class, 'regencies']);
    Route::get('/districts/{id}', [WilayahController::class, 'districts']);
    Route::get('/villages/{id}', [WilayahController::class, 'villages']);
});

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // --- Profile Management ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- User Anggota & Pembayaran ---
    Route::post('user-anggota/{anggota}/request-edit', [UserAnggotaController::class, 'requestEdit'])
        ->name('user-anggota.request-edit');

    Route::post('user-anggota/{anggota}/pembayaran', [UserAnggotaController::class, 'uploadPembayaran'])
        ->name('user-anggota.pembayaran.upload');

    Route::delete('user-anggota/request-edit/{anggotaEditRequest}', [UserAnggotaController::class, 'cancelRequestEdit'])
        ->name('user-anggota.request-edit.destroy');

    Route::post('/user-anggota/check-certificate', [UserAnggotaController::class, 'checkCertificate'])->name('user-anggota.check-certificate');

    Route::resource('user-anggota', UserAnggotaController::class)
        ->names('user-anggota')
        ->parameters(['user-anggota' => 'anggota']);

    // --- User Pelatihan & Pendaftaran ---
    Route::get('user-pelatihan/{pelatihan}/daftar', [UserPelatihanController::class, 'create'])->name('user-pelatihan.daftar');
    Route::post('user-pelatihan/{pelatihan}/daftar', [UserPelatihanController::class, 'store'])->name('user-pelatihan.store');

    Route::get('user-pelatihan/pembayaran/{pelatihanAnggota}', [UserPelatihanController::class, 'payment'])->name('user-pelatihan.payment');
    Route::post('user-pelatihan/pembayaran/{pelatihanAnggota}', [UserPelatihanController::class, 'processPayment'])->name('user-pelatihan.payment.store');

    Route::get('user-pelatihan/status/{pelatihanAnggota}', [UserPelatihanController::class, 'status'])->name('user-pelatihan.status');

    Route::resource('user-pelatihan', UserPelatihanController::class)
        ->names('user-pelatihan')
        ->parameters(['user-pelatihan' => 'pelatihan']);

    Route::get('/pelatihan/{pelatihan}/sertifikat', [UserPelatihanController::class, 'cetakSertifikat'])->name('user.sertifikat');
    Route::get('/pelatihan/{pelatihan}/sertifikat/download', [UserPelatihanController::class, 'downloadSertifikat'])->name('user.sertifikat.download');
    Route::get('/pelatihan/{pelatihan}/sertifikat/download-pdf', [UserPelatihanController::class, 'downloadSertifikatPdf'])->name('user.sertifikat.download.pdf');
    // --- User Materi & Kuis/Soal Pelatihan ---
    Route::get('pelatihan-materi/{pelatihanId}', [UserMateriController::class, 'index'])->name('user-materi.index');
    Route::get('pelatihan-materi/{pelatihanId}/{materiId}', [UserMateriController::class, 'show'])->name('user-materi.show');
    Route::get('/pelatihan-materi/{pelatihanId}/sertifikat', [UserMateriController::class, 'sertifikat'])->name('materi.sertifikat');
    Route::get('/pelatihan-sertifikat', [UserMateriController::class, 'daftarSertifikat'])->name('sertifikat.index');

    Route::get('/pelatihan/{pelatihan}/materi/{materi}/soal', [UserSoalController::class, 'index'])->name('user-soal.index');
    Route::post('/pelatihan/{pelatihan}/materi/{materi}/soal', [UserSoalController::class, 'store'])->name('user-soal.store');

    // Route untuk Remidi
    Route::get('/pelatihan/{pelatihan}/materi/{materi}/remedi', [UserSoalController::class, 'remedi'])->name('user-soal.remedi');
    Route::post('/pelatihan/{pelatihan}/materi/{materi}/remedi/store', [UserSoalController::class, 'storeRemedi'])->name('user-soal.store-remedi');
    /*
    |--------------------------------------------------------------------------
    | Admin Group Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin')->name('admin.')->group(function () {

        // --- Anggota Card Custom & Resource Actions ---
        Route::get('anggota-card/{id}/download', [AnggotaCardController::class, 'download'])
            ->name('anggota-card.download');

        Route::get('anggota-card/{anggotaCard}/qr-code/download', [AnggotaCardController::class, 'downloadQR'])
            ->name('anggota-card.qr.download');

        Route::post('anggota-card/{anggotaCard}/status', [AnggotaCardController::class, 'status'])
            ->name('anggota-card.status');

        Route::post('anggota-card/{anggotaCard}/simpan-kartu', [AnggotaCardController::class, 'simpanKartu'])
            ->name('anggota-card.simpan-kartu');

        Route::post('anggota-card/{anggotaCard}/process-edit-request', [AnggotaCardController::class, 'processEditRequest'])
            ->name('anggota-card.process-edit-request');

        Route::resource('anggota', AnggotaController::class)->parameters(['anggota' => 'anggota']);
        Route::resource('anggota-card', AnggotaCardController::class);

        // --- Permissions & Roles Management ---
        Route::get('/permissions/task/{task_name}/edit', [PermissionController::class, 'editTask'])->name('permissions.editTask');
        Route::put('/permissions/task/{task_name}', [PermissionController::class, 'updateTask'])->name('permissions.updateTask');
        Route::delete('/permissions/task/{task_name}', [PermissionController::class, 'destroyTask'])->name('permissions.destroyTask');

        Route::resource('role', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        // --- User Management ---
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

        // --- Pelatihan & Materi Management (Admin) ---
        Route::resource('pelatihan', PelatihanController::class);
        Route::resource('pelatihan.materi', MateriController::class);
        Route::get('materi', [MateriController::class, 'index'])->name('materi.index');

        // --- Soal Management (Admin) ---
        Route::resource('materi/{materi}/soal', SoalController::class)
            ->except(['show'])
            ->names('materi.soal');

        // --- Pelatihan Anggota & Verifikasi Pembayaran ---
        Route::get('/pelatihan-anggota/pembayaran', [PelatihanAnggotaController::class, 'index'])
            ->name('pelatihan-anggota.index');

        Route::get('/pelatihan-anggota/pembayaran/{id}', [PelatihanAnggotaController::class, 'show'])
            ->name('pelatihan-anggota.show');

        Route::post('/pelatihan/verifikasi-pembayaran/{id}', [PelatihanAnggotaController::class, 'updateVerifikasi'])
            ->name('pelatihan.verifikasi.update');
    });
});

require __DIR__ . '/auth.php';
