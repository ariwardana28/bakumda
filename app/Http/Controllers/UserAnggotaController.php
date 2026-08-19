<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\AnggotaCard;
use App\Models\AnggotaStatus;
use App\Models\AnggotaPengajuan;
use App\Models\AnggotaStatusPengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Sertifikat;

class UserAnggotaController extends Controller
{

    public static function middleware(): array
    {
        return [
            'permission:keanggotaan-view'   => ['only' => ['index', 'show']],
            'permission:keanggotaan-create' => ['only' => ['show', 'status', 'simpanKartu']],
            'permission:keanggotaan-edit' => ['only' => ['edit', 'update']],
            'permission:keanggotaan-download'   => ['only' => ['show', 'status', 'download']],

        ];
    }
    /**
     * Menampilkan data anggota yang terhubung dengan user yang sedang login.
     */
    public function index()
    {
        $anggota = Anggota::with(['card.statuses'])
            ->where('user_id', Auth::id())
            ->first();

        return view('admin.keanggotaan.index', compact('anggota'));
    }

    public function create()
    {
        $anggota = Anggota::with('card.latestStatus')
            ->where('user_id', Auth::id())
            ->first();

        // Jika anggota ditemukan dan status terakhirnya adalah 'ditolak' atau 'rejected',
        // kita akan mengirimkan data lama ke view untuk diisi ulang.
        if ($anggota && $anggota->card && $anggota->card->latestStatus) {
            $latestStatus = strtolower($anggota->card->latestStatus->status);
            if (in_array($latestStatus, ['ditolak', 'rejected'])) {
                return view('admin.keanggotaan.create', compact('anggota'));
            }
        }

        // Jika tidak ada data lama atau statusnya bukan ditolak, tampilkan form kosong.
        // Kita tetap mengirim variabel $anggota (yang akan bernilai null) agar view tidak error.
        $anggota = null;
        return view('admin.keanggotaan.create', compact('anggota'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'no_ktp'            => 'required|string|digits:16|unique:anggota,no_ktp',
            'foto'              => 'required|image|mimes:jpeg,png,jpg|max:2048', // maks 2MB
            'foto_ktp'          => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048', // maks 2MB
            'pakta_integritas'  => 'required|in:approve',
        ], [
            'no_ktp.unique'         => 'NIK / No. KTP ini sudah terdaftar sebagai anggota.',
            'no_ktp.digits'         => 'NIK / No. KTP harus persis 16 digit angka.',
            'foto.max'              => 'Ukuran pas foto tidak boleh lebih dari 2MB.',
            'foto_ktp.max'          => 'Ukuran file KTP tidak boleh lebih dari 2MB.',
            'pakta_integritas.required' => 'Anda wajib menyetujui syarat & ketentuan (Pakta Integritas) terlebih dahulu.',
            'pakta_integritas.in'       => 'Persetujuan Pakta Integritas tidak valid.',
        ]);

        DB::beginTransaction();

        try {
            // 2. Upload Berkas ke Storage (Hanya untuk foto dan foto_ktp)
            if ($request->hasFile('foto')) {
                $validated['foto'] = $request->file('foto')->store('anggota/foto', 'public');
            }

            if ($request->hasFile('foto_ktp')) {
                $validated['foto_ktp'] = $request->file('foto_ktp')->store('anggota/ktp', 'public');
            }

            // 3. Tambahkan data pendukung
            $validated['user_id'] = Auth::id();

            // 4. Simpan ke Database
            $anggota = Anggota::create($validated);

            $anggota_id = $anggota->id;
            $anggotaCard = new AnggotaCard();
            $anggotaCard->anggota_id = $anggota_id;
            $anggotaCard->save();

            $anggotaStatus = new AnggotaStatus();
            $anggotaStatus->anggota_card_id = $anggotaCard->id;
            $anggotaStatus->user_id = Auth::id(); // ID Admin yang sedang login
            $anggotaStatus->status = 'PROSES';
            $anggotaStatus->keterangan = 'Anggota baru ditambahkan dan sedang dalam proses verifikasi.';
            $anggotaStatus->save();

            DB::commit();

            return redirect()->route('user-anggota.index')
                ->with('success', 'Pendaftaran anggota berhasil dikirim. Silakan tunggu verifikasi admin.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Hapus berkas yang sempat ter-upload jika terjadi kegagalan database
            if (isset($validated['foto'])) Storage::disk('public')->delete($validated['foto']);
            if (isset($validated['foto_ktp'])) Storage::disk('public')->delete($validated['foto_ktp']);

            return back()->withInput()->with('error', 'Gagal memproses pendaftaran: ' . $e->getMessage());
        }
    }
    /**
     * Menampilkan form untuk mengedit data anggota.
     *
     * @param  \App\Models\Anggota  $anggota
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, Anggota $anggota)
    {

        // Otorisasi: Pastikan user yang login adalah pemilik data anggota.
        if ($anggota->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        // Cek apakah ada permintaan edit yang disetujui (menggunakan relasi yang sudah ada)
        $hasApprovedRequest = $anggota->pendingEditRequest()->exists();

        // Cek status kartu saat ini
        $currentStatus = strtolower($anggota->card->latestStatus->status ?? '');
        $isProcessing = $currentStatus === 'proses';

        // Cek apakah kartu kedaluwarsa
        $isExpired = false;
        if ($anggota->card && $anggota->card->latestBerlaku && $anggota->card->latestBerlaku->berlaku) {
            if (\Carbon\Carbon::parse($anggota->card->latestBerlaku->berlaku)->isPast()) {
                $isExpired = true;
                // Jika status aslinya 'aktif' tapi sudah kedaluwarsa, anggap sebagai 'non-aktif' untuk logic ini
                if ($currentStatus === 'aktif') {
                    $currentStatus = 'non-aktif';
                }
            }
        }

        // User hanya bisa edit jika:
        // 1. Status pendaftaran masih 'PROSES'.
        // 2. Atau ada permintaan perubahan data yang statusnya 'approved'.
        // 3. Atau status kartu 'non-aktif' (kedaluwarsa) untuk perpanjangan.
        if (!$isProcessing && !$hasApprovedRequest && !$isExpired) {
            return redirect()->route('user-anggota.index')
                ->with('error', 'Anda tidak dapat mengedit data saat ini. Silakan ajukan permintaan perubahan terlebih dahulu.');
        }

        // Load relasi jika diperlukan di view
        $anggota->load('card.latestStatus');

        // Tampilkan view 'edit' dengan melewatkan data anggota
        return view('admin.keanggotaan.edit', compact('anggota'));
    }

    public function requestEdit(Request $request, Anggota $anggota)
    {


        // $request->validate(['keterangan' => 'required|string|min:10']);

        DB::beginTransaction();
        try {
            // 1. Buat pengajuan edit baru
            $pengajuan = AnggotaPengajuan::create([
                'anggota_card_id' => $anggota->card->id,
                'action' => 'edit',
                'user_id' => Auth::id(),
                'keterangan' => $request->keterangan,
            ]);

            // 2. Buat status awal untuk pengajuan tersebut
            AnggotaStatusPengajuan::create([
                'anggota_pengajuan_id' => $pengajuan->id,
                'status' => 'proses',
                'keterangan' => 'Pengajuan perubahan data telah dibuat dan menunggu review admin.',
            ]);

            DB::commit();
            return redirect()->route('user-anggota.index')->with('success', 'Permintaan untuk mengubah data telah dikirim. Mohon tunggu persetujuan admin.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal mengirim permintaan: ' . $e->getMessage());
        }
    }

    // public function cancelRequestEdit(AnggotaPengajuan $anggotaPenagjuan)
    // {
    //     // Otorisasi: Pastikan user yang login adalah pemilik permintaan.
    //     if ($anggotaPenagjuan->user_id !== Auth::id()) {
    //         abort(403, 'Anda tidak memiliki izin untuk melakukan tindakan ini.');
    //     }

    //     DB::beginTransaction();
    //     try {
    //         // Tambahkan status baru 'dibatalkan' ke pengajuan
    //         AnggotaStatusPengajuan::create([
    //             'anggota_pengajuan_id' => $anggotaPenagjuan->id,
    //             'status' => 'dibatalkan',
    //             'keterangan' => 'Permintaan perubahan data dibatalkan oleh pengguna.',
    //         ]);

    //         // Update status utama pada tabel pengajuan itu sendiri
    //         // $anggotaEditRequest->status = 'dibatalkan';
    //         // $anggotaEditRequest->processed_by = Auth::id();
    //         // $anggotaEditRequest->processed_at = now();
    //         // $anggotaEditRequest->save();
    //         DB::commit();

    //         return redirect()->route('user-anggota.index')->with('success', 'Permintaan perubahan data berhasil dibatalkan.');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->route('user-anggota.index')->with('error', 'Gagal membatalkan permintaan: ' . $e->getMessage());
    //     }
    // }

    /**
     * Memperbarui data anggota di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Anggota  $anggota
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Anggota $anggota)
    {
        // Otorisasi: Pastikan user yang login adalah pemilik data anggota.
        if ($anggota->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk melakukan tindakan ini.');
        }

        // 1. Validasi Input
        $validated = $request->validate([
            'nama'              => 'required|string|max:255',
            // NIK harus unik, kecuali untuk NIK milik anggota ini sendiri
            'no_ktp'            => 'required|numeric|digits:16|unique:anggota,no_ktp,' . $anggota->id,
            'jenis_kelamin'     => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir'      => 'required|string|max:100',
            'tanggal_lahir'     => 'required|date',
            'agama'             => 'required|string|max:50',
            'status_perkawinan' => 'required|string|max:50',
            'pekerjaan'         => 'required|string|max:100',
            'kewarganegaraan'   => 'required|in:WNI,WNA',
            'email'             => 'required|email|max:255',
            'no_hp'             => 'required|string|max:20',
            'alamat'            => 'required|string',
            'provinsi'          => 'nullable|string|max:255',
            'kota'              => 'nullable|string|max:255',
            'kecamatan'         => 'nullable|string|max:255',
            'kelurahan'         => 'nullable|string|max:255',
            // File tidak wajib diisi saat update
            'foto'              => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_ktp'          => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'pakta_integritas'  => 'nullable|file|mimes:pdf|max:5120',
            'keterangan'        => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            // 2. Handle File Uploads (jika ada file baru)
            foreach (['foto', 'foto_ktp', 'pakta_integritas'] as $fileField) {
                if ($request->hasFile($fileField)) {
                    // Hapus file lama jika ada
                    if ($anggota->{$fileField}) {
                        Storage::disk('public')->delete($anggota->{$fileField});
                    }
                    // Simpan file baru dan update path di data validasi
                    $folder = ($fileField === 'foto') ? 'anggota/foto' : (($fileField === 'foto_ktp') ? 'anggota/ktp' : 'anggota/pakta');
                    $validated[$fileField] = $request->file($fileField)->store($folder, 'public');
                }
            }

            // 3. Update data anggota
            $anggota->update($validated);

            // 4. Reset status menjadi 'PROSES' karena ada pengajuan ulang
            $anggotaCard = $anggota->card;
            if ($anggotaCard) {
                AnggotaStatus::create([
                    'anggota_card_id' => $anggotaCard->id,
                    'user_id'         => Auth::id(),
                    'status'          => 'PROSES',
                    'keterangan'      => 'Data pendaftaran diperbarui dan diajukan kembali untuk verifikasi.',
                ]);
            }

            // Catatan: Proses update oleh anggota tidak mengubah data masa berlaku kartu (AnggotaBerlaku).
            // Perubahan masa berlaku, jabatan, dan penerbitan kartu hanya dilakukan oleh Admin.

            // 5. Tandai permintaan edit yang disetujui sebagai 'selesai'
            $approvedRequest = $anggota->editRequests()
                ->whereHas('latestStatus', function ($query) {
                    $query->where('status', 'approved');
                })
                ->latest()
                ->first();

            if ($approvedRequest) {
                AnggotaStatusPengajuan::create([
                    'anggota_pengajuan_id' => $approvedRequest->id,
                    'status' => 'selesai',
                    'keterangan' => 'Data anggota telah berhasil diperbarui oleh pengguna.',
                ]);
            }

            DB::commit();

            return redirect()->route('user-anggota.index')
                ->with('success', 'Data pendaftaran berhasil diperbarui dan diajukan kembali.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Hapus file baru yang terlanjur di-upload jika terjadi error
            foreach (['foto', 'foto_ktp', 'pakta_integritas'] as $fileField) {
                if (isset($validated[$fileField]) && $request->hasFile($fileField)) {
                    Storage::disk('public')->delete($validated[$fileField]);
                }
            }
            return back()->withInput()->with('error', 'Gagal memperbarui pendaftaran: ' . $e->getMessage());
        }
    }


    public function uploadPembayaran(Request $request, Anggota $anggota)
    {
        // Otorisasi: Pastikan user yang login adalah pemilik data anggota.
        if ($anggota->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk melakukan tindakan ini.');
        }

        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'bukti_pembayaran.required' => 'Anda harus mengunggah file bukti pembayaran.',
            'bukti_pembayaran.image' => 'File yang diunggah harus berupa gambar.',
            'bukti_pembayaran.max' => 'Ukuran file tidak boleh lebih dari 2MB.',
        ]);

        DB::beginTransaction();
        try {
            $path = $request->file('bukti_pembayaran')->store('anggota/pembayaran', 'public');

            // 1. Simpan data ke tabel anggota_pembayaran
            $pembayaran = \App\Models\AnggotaPembayaran::create([
                'anggota_card_id' => $anggota->card->id,
                'bulan' => now()->month,
                'tahun' => now()->year,
                'status' => 'diproses',
                'bukti_pembayaran' => $path,
                'keterangan' => 'Pembayaran diunggah oleh anggota.',
            ]);

            // Buat status baru 'Pembayaran Diproses'
            AnggotaStatus::create([
                'anggota_card_id' => $anggota->card->id,
                'user_id'         => Auth::id(),
                'status'          => 'Pembayaran Diproses',
                'keterangan'      => 'Bukti pembayaran telah diunggah. Menunggu verifikasi admin. Ref Pembayaran: ' . $pembayaran->id,
            ]);

            DB::commit();
            return redirect()->route('user-anggota.index')->with('success', 'Bukti pembayaran berhasil diunggah. Mohon tunggu konfirmasi dari admin.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengunggah bukti pembayaran: ' . $e->getMessage());
        }
    }

    public function checkCertificate(Request $request)
    {
        $request->validate([
            'nomor_sertifikat' => 'required|string',
        ]);

        // 1. Cek apakah nomor sertifikat ada di database tabel 'sertifikat' (kolom 'no_sertifikat')
        $sertifikat = Sertifikat::where('no_sertifikat', $request->nomor_sertifikat)->first();

        if (!$sertifikat) {
            return response()->json([
                'valid' => false,
                'message' => 'Nomor sertifikat tidak ditemukan di dalam database.'
            ], 422);
        }

        /* 
      Catatan relasi berdasarkan struktur database Anda:
      Sertifikat -> sertifikat_nilai -> Nilai -> pelatihan_anggota -> users_id
      Jika Anda ingin memastikan sertifikat ini benar milik user yang sedang login, 
      pastikan relasi ke user valid. (Opsional/Sesuaikan dengan kebutuhan bisnis Anda)
    */

        return response()->json([
            'valid' => true,
            'message' => 'Nomor sertifikat valid dan berhasil diverifikasi!'
        ]);
    }

    /**
     * Mengecek status keanggotaan terbaru untuk polling real-time.
     *
     * @param  \App\Models\Anggota  $anggota
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkStatus(Anggota $anggota)
    {
        // Otorisasi: Pastikan user yang login adalah pemilik data anggota.
        if ($anggota->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $anggota->load('card.latestStatus', 'card.latestBerlaku');

        $currentStatus = optional($anggota->card->latestStatus)->status ? strtolower($anggota->card->latestStatus->status) : 'proses';

        // Cek apakah kartu sudah kedaluwarsa dan ubah statusnya jika perlu
        if ($currentStatus === 'aktif' && $anggota->card && $anggota->card->latestBerlaku) {
            if (\Carbon\Carbon::parse($anggota->card->latestBerlaku->berlaku)->isPast()) {
                $currentStatus = 'non-aktif';
            }
        }

        return response()->json([
            'status' => $currentStatus
        ]);
    }
}
