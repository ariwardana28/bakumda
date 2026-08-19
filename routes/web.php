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
use App\Http\Controllers\Admin\SuratJenisController;
use App\Http\Controllers\HalamanUtamaController;
use App\Http\Controllers\UserMateriController;
use App\Http\Controllers\Admin\SoalController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\UserProdukController;
use App\Http\Controllers\Admin\KorwilController;
use App\Http\Controllers\RefferalController;
use App\Http\Controllers\GeminiController;
/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/ai-chat', [GeminiController::class, 'index']);
Route::post('/ai/ask', [GeminiController::class, 'ask'])->name('gemini.ask');

Route::get('/', [HalamanUtamaController::class, 'index'])->name('welcome');
Route::get('/korwil', [HalamanUtamaController::class, 'korwil'])->name('korwil');
Route::get('/korwil/{province}', [HalamanUtamaController::class, 'showKorwilByProvince'])->name('user.korwil.show');
Route::get('/korwil/surat/{anggotaCard}', [HalamanUtamaController::class, 'showKorwilSurat'])->name('user.korwil.surat');
Route::get('/artiekl/{artikel:slug}', [HalamanUtamaController::class, 'show'])->name('artikel.show.public');

// Route untuk Pengecekan Sertifikat Publik
Route::get('/cek-sertifikat', [HalamanUtamaController::class, 'showCekSertifikatForm'])->name('sertifikat.cek.form');
Route::post('/cek-sertifikat', [HalamanUtamaController::class, 'CekSertifikat'])->name('sertifikat.cek.submit');

// Route untuk Pengecekan Kartu Anggota Publik
Route::get('/cek-kartu-anggota', [HalamanUtamaController::class, 'showCekKartuAnggotaForm'])->name('kartu-anggota.cek.form');
Route::post('/cek-kartu-anggota', [HalamanUtamaController::class, 'CekKartuAnggota'])->name('kartu-anggota.cek.submit');

// Route untuk menampilkan detail artikel publik
Route::get('/artikel/{artikel:slug}', [HalamanUtamaController::class, 'show'])->name('artikel.show.public');

Route::get('/admin/surat', function () {
    return view('admin.surat.index');
});

Route::get('/admin/surat/surat-perjanjian-kerja-waktu-tertentu-pkwt', function () {
    return view('admin.surat.pkwt');
});

Route::get('/admin/surat/surat-perjanjian-hutang-piutang', function () {
    return view('admin.surat.hutang');
});

Route::get('/admin/surat/surat-perjanjian-kerja-sama', function () {
    return view('admin.surat.kerja-sama');
});

Route::get('/admin/surat/surat-permohonan', function () {
    return view('admin.surat.permohonan');
});

Route::get('/admin/surat/surat-pengunduran-diri', function () {
    return view('admin.surat.pengunduran-diri');
});

Route::get('/admin/surat/surat-jual-beli', function () {
    return view('admin.surat.jual-beli');
});

Route::get('/admin/surat/surat-sewa', function () {
    return view('admin.surat.sewa');
});

Route::get('/admin/surat/surat-keterangan-kerja', function () {
    return view('admin.surat.keterangan-kerja');
});

Route::get('/admin/surat/surat-perjanjian-perdamaian', function () {
    return view('admin.surat.perdamaian');
});

Route::get('/admin/surat/surat-pencabutan-kuasa', function () {
    return view('admin.surat.pencabutan-kuasa');
});

Route::get('user-surat', function () {
    return view('user.surat.index');
});

Route::get('user-surat/surat-perjanjian-kerja-waktu-tertentu-pkwt', function () {
    return view('user.surat.pkwt');
});

Route::get('user-surat/surat-perjanjian-hutang-piutang', function () {
    return view('user.surat.hutang');
});

Route::get('user-surat/surat-perjanjian-kerja-sama', function () {
    return view('user.surat.kerja-sama');
});

Route::get('user-surat/surat-permohonan', function () {
    return view('user.surat.permohonan');
});

Route::get('user-surat/surat-pengunduran-diri', function () {
    return view('user.surat.pengunduran-diri');
});

Route::get('user-surat/surat-jual-beli', function () {
    return view('user.surat.jual-beli');
});

Route::get('user-surat/surat-sewa', function () {
    return view('user.surat.sewa');
});

Route::get('user-surat/surat-keterangan-kerja', function () {
    return view('user.surat.keterangan-kerja');
});

Route::get('user-surat/surat-perjanjian-perdamaian', function () {
    return view('user.surat.perdamaian');
});

Route::get('user-surat/surat-pencabutan-kuasa', function () {
    return view('user.surat.pencabutan-kuasa');
});

Route::get('about', function () {
    return view('about');
});

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
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/aturan-pengguna', [ProfileController::class, 'aturanPengguna'])->name('profile.aturan-pengguna');
    Route::get('/profile/kebijakan-privasi', [ProfileController::class, 'kebijakanPrivasi'])->name('profile.kebijakan-privasi');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Marchaindise
    Route::get('/merchandise', [UserProdukController::class, 'index'])->name('merchandise.index');
    Route::get('/merchandise/{slug}', [UserProdukController::class, 'show'])->name('merchandise.show');

    // --- User Anggota & Pembayaran ---
    Route::post('user-anggota/{anggota}/request-edit', [UserAnggotaController::class, 'requestEdit'])
        ->name('user-anggota.request-edit');

    Route::post('user-anggota/{anggota}/pembayaran', [UserAnggotaController::class, 'uploadPembayaran'])
        ->name('user-anggota.pembayaran.upload');

    Route::delete('user-anggota/request-edit/{anggotaEditRequest}', [UserAnggotaController::class, 'cancelRequestEdit'])
        ->name('user-anggota.request-edit.destroy');

    Route::post('/user-anggota/check-certificate', [UserAnggotaController::class, 'checkCertificate'])->name('user-anggota.check-certificate');

    Route::get('/anggota/status-check/{anggota}', [UserAnggotaController::class, 'checkStatus'])
        ->name('user-anggota.status.check');

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
    | User Artikel Routes
    |--------------------------------------------------------------------------
    */
    Route::resource('artikel', ArtikelController::class)->names('user.artikel')->parameter('artikel', 'artikel:slug');

    // Refferal
    Route::resource('inspirator', App\Http\Controllers\ReferralController::class)
        ->names('user-referral');
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

        // --- Manajemen Surat ---
        Route::resource('surat-jenis', SuratJenisController::class);

        // --- Manajemen Produk ---
        Route::resource('produk', \App\Http\Controllers\Admin\ProdukController::class);
        Route::resource('korwil', KorwilController::class);

        // Endpoint untuk auto-fill form korwil
        Route::get('/korwil/get-latest-data/{anggotaCard}', [KorwilController::class, 'getLatestKorwilData'])->name('korwil.get-latest-data');
    });
});

require __DIR__ . '/auth.php';
