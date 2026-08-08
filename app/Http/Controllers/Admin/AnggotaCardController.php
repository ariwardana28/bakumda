<?php

namespace App\Http\Controllers\Admin;

use App\Models\Anggota;
use App\Http\Controllers\Controller;
use App\Models\AnggotaCard;
use App\Models\AnggotaStatus; // Import model AnggotaStatus
use App\Models\AnggotaBerlaku; // Import model AnggotaBerlaku
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Common\EccLevel;
use Illuminate\Support\Facades\Auth;
use App\Models\AnggotaPengajuan;
use App\Models\AnggotaStatusPengajuan;
use App\Models\AnggotaPembayaran;
use Illuminate\Support\Str;

class AnggotaCardController extends Controller
{
    public static function middleware(): array
    {
        return [
            'permission:kartu-anggota-view'   => ['only' => ['index', 'show']],
            'permission:kartu-anggota-create' => ['only' => ['show', 'status', 'simpanKartu']],
            'permission:kartu-anggota-download'   => ['only' => ['download', 'processEditRequest']],
            'permission:kartu-anggota-request' => ['only' => ['show', 'processEditRequest']],

        ];
    }

    public function index(Request $request)
    {
        // 1. Query untuk menghitung jumlah data per status dengan efisien
        $statusCounts = AnggotaStatus::select('status', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->whereIn('id', function ($query) {
                $query->select(\Illuminate\Support\Facades\DB::raw('max(id)'))
                    ->from('anggota_status')
                    ->groupBy('anggota_card_id');
            })
            ->groupBy('status')
            ->pluck('total', 'status')
            ->mapWithKeys(function ($total, $status) {
                // Normalisasi key status menjadi lowercase untuk konsistensi
                return [strtolower($status) => $total];
            });

        // 2. Query utama untuk mengambil data kartu anggota dengan filter dan pencarian
        $query = AnggotaCard::with(['anggota', 'latestStatus'])->latest();

        // Filter berdasarkan status dari request
        if ($request->filled('status')) {
            $status = strtolower($request->status);
            $query->whereHas('latestStatus', function ($q) use ($status) {
                if ($status === 'aktif') {
                    $q->whereIn('status', ['approved', 'disetujui', 'aktif']);
                } else {
                    $q->where('status', $status);
                }
            });
        }

        // Filter berdasarkan pencarian nama
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('anggota', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            });
        }

        // 3. Ambil data dengan paginasi
        $anggotaCards = $query->paginate(10)->withQueryString();

        // 4. Kirim data ke view
        return view('admin.anggota_card.index', compact('anggotaCards', 'statusCounts'));
    }

    public function show(AnggotaCard $anggotaCard)
    {
        $anggotaCard->load(['anggota.pendingEditRequest']);
        $pendingEditRequest = $anggotaCard->anggota->pendingEditRequest;
        return view('admin.anggota_card.show', compact('anggotaCard', 'pendingEditRequest'));
    }

    public function status(Request $request, AnggotaCard $anggotaCard)
    {
        // 1. Validasi request
        $validated = $request->validate([
            'status' => 'required|string|in:approved,rejected,diterbitkan,ditolak,pembayaran_diterima',
            'keterangan' => 'nullable|string',
        ]);

        $newStatus = $validated['status'];
        $keterangan = $validated['keterangan'] ?? null;

        // INTERCEPT: Jika admin menyetujui, ubah status menjadi 'Menunggu Pembayaran'
        if (in_array($validated['status'], ['approved', 'diterbitkan'])) {
            $newStatus = 'Menunggu Pembayaran';
            $keterangan = 'Data disetujui, menunggu pembayaran biaya keanggotaan.';
        }

        // Jika pembayaran diterima, generate kartu dan set status menjadi 'Aktif'
        if ($validated['status'] === 'pembayaran_diterima') {
            $newStatus = 'Aktif'; // Status final setelah pembayaran
            $keterangan = $validated['keterangan'] ?? 'Pembayaran telah dikonfirmasi. Kartu Tanda Anggota telah diterbitkan.';

            // Cek apakah ini pendaftaran baru atau perpanjangan
            if (!$anggotaCard->card_id) {
                // --- LOGIKA PENDAFTARAN BARU ---
                $year = now()->year;
                $lastCard = AnggotaCard::where('card_id', 'LIKE', "KTPA.{$year}.%")->orderBy('id', 'desc')->first();
                $nextNumber = 1;
                if ($lastCard && $lastCard->card_id) {
                    $parts = explode('.', $lastCard->card_id);
                    $lastNumber = (int) end($parts);
                    $nextNumber = $lastNumber + 1;
                }
                $cardId = 'KTPA.' . $year . '.' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

                $qrData = 'https://ujicoba.maharadjalawfirm.com/anggota/' . $cardId;
                $filename = "qrcodes/{$cardId}.svg";
                $options = new QROptions(['version' => 5, 'eccLevel' => EccLevel::L, 'outputType' => 'svg', 'outputBase64' => false]);
                $qrCodeImage = (new QRCode($options))->render($qrData);
                Storage::disk('public')->put($filename, $qrCodeImage);

                $anggotaCard->card_id = $cardId;
                $anggotaCard->qr_code = $filename;
                $anggotaCard->save(); // Simpan perubahan card_id dan qr_code ke database
                if ($anggotaCard->anggota) {
                    $anggotaCard->anggota->update(['card_id' => $cardId]);
                }

                // Buat masa berlaku baru
                $anggotaCard->berlakuHistory()->create([
                    'diterbitkan' => now(),
                    'berlaku' => now()->addYears(1),
                    'status_kartu' => 'Aktif',
                    'jabatan' => 'Anggota', // Set jabatan default untuk pendaftaran baru
                ]);
            } else {
                // --- LOGIKA PERPANJANGAN ---
                $latestBerlaku = $anggotaCard->latestBerlaku;
                $newBerlakuDate = now()->addYears(1); // Default jika tidak ada data lama

                if ($latestBerlaku && $latestBerlaku->berlaku) {
                    // Tambah 1 tahun dari masa berlaku terakhir
                    $newBerlakuDate = \Carbon\Carbon::parse($latestBerlaku->berlaku)->addYears(1);
                }

                // Buat record masa berlaku baru untuk perpanjangan
                $anggotaCard->berlakuHistory()->create([
                    'diterbitkan' => now(),
                    'berlaku' => $newBerlakuDate,
                    'status_kartu' => 'Perpanjangan',
                    'keterangan' => 'Perpanjangan masa berlaku kartu.',
                    'jabatan' => 'Anggota', // Set jabatan default untuk perpanjangan
                ]);
            }

            // Update status di tabel anggota_pembayaran
            $pembayaran = AnggotaPembayaran::where('anggota_card_id', $anggotaCard->id)
                ->where('status', 'diproses')
                ->latest()
                ->first();

            if ($pembayaran) {
                $pembayaran->status = 'diterima';
                $pembayaran->save();
            }

        }
        // Simpan riwayat status baru
        AnggotaStatus::create([
            'anggota_card_id' => $anggotaCard->id,
            'user_id'         => auth()->id(), // ID Admin yang sedang login
            'status'          => $newStatus,
            'keterangan'      => $keterangan,
        ]);

        return redirect()->route('admin.anggota-card.show', $anggotaCard->id)
            ->with('success', 'Status kartu anggota berhasil diperbarui.');
    }

    public function simpanKartu(Request $request, AnggotaCard $anggotaCard)
    {
        // 1. Validasi input dari form
        $validated = $request->validate([
            'jabatan'     => 'required|string|max:255',
            'diterbitkan' => 'required|date',
            'berlaku'     => 'required|date',
            'keterangan'  => 'nullable|string',
        ]);

        // Cari data berlaku terakhir dan perbarui, atau buat baru jika tidak ada.
        $anggotaCard->berlakuHistory()->updateOrCreate(
            // Kunci untuk mencari: dalam kasus ini, kita ingin selalu update/create untuk card ini,
            // jadi kita bisa gunakan atribut yang pasti ada atau biarkan kosong jika relasi sudah handle.
            // Untuk memastikan hanya satu record per kartu yang diupdate, kita bisa set kuncinya.
            ['anggota_card_id' => $anggotaCard->id],
            // Data untuk diperbarui atau dibuat
            [
                'jabatan'      => $validated['jabatan'],
                'diterbitkan'  => $validated['diterbitkan'],
                'berlaku'      => $validated['berlaku'],
                'status_kartu' => 'AKTIF',
                'keterangan'   => $validated['keterangan'],
            ]
        );

        // Buat juga riwayat statusnya
        $anggotaCard->statuses()->create([
            'anggota_card_id' => $anggotaCard->id,
            'user_id'         => Auth::id(),
            'status'          => 'AKTIF',
            'keterangan'      => 'Informasi kartu (jabatan/masa berlaku) telah diperbarui.',
        ]);

        return redirect()->route('admin.anggota-card.show', $anggotaCard->id)
            ->with('success', 'Status kartu anggota berhasil diperbarui.');
    }


    public function download($id)
    {
        $anggotaCard = AnggotaCard::with('anggota')->findOrFail($id);

        // Tampilkan halaman preview yang akan otomatis mengunduh kartu sebagai gambar menggunakan html2canvas
        return view('admin.anggota_card.download-image', compact('anggotaCard'));
    }

    public function processEditRequest(Request $request, AnggotaCard $anggotaCard)
    {
        $validated = $request->validate([
            'request_id' => 'required|exists:anggota_pengajuan,id',
            'action' => 'required|in:approve,reject',
            'catatan_admin' => 'nullable|string',
        ]);

        $pengajuan = AnggotaPengajuan::findOrFail($validated['request_id']);

        // Pastikan request ini milik anggota yang benar
        if ($pengajuan->anggota_card_id !== $anggotaCard->id) {
            return back()->with('error', 'Request tidak sesuai.');
        }

        if ($validated['action'] === 'approve') {
            AnggotaStatusPengajuan::create([
                'anggota_pengajuan_id' => $pengajuan->id,
                'status' => 'approved',
                'keterangan' => 'Permintaan disetujui oleh admin. ' . ($validated['catatan_admin'] ?? ''),
            ]);
            $message = 'Permintaan perubahan data disetujui. Anggota sekarang dapat mengedit datanya.';
        } else { // reject
            AnggotaStatusPengajuan::create([
                'anggota_pengajuan_id' => $pengajuan->id,
                'status' => 'rejected',
                'keterangan' => 'Permintaan ditolak oleh admin. ' . ($validated['catatan_admin'] ?? ''),
            ]);
            $message = 'Permintaan perubahan data ditolak.';
        }

        return redirect()->route('admin.anggota-card.show', $anggotaCard->id)->with('success', $message);
    }
}
