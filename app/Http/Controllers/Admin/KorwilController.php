<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AnggotaBerlaku;
use App\Models\AnggotaCard;

class KorwilController extends Controller
{
    /**
     * Menampilkan daftar semua data Anggota Berlaku.
     */
    public function index()
    {
        $korwils = AnggotaBerlaku::with('anggotaCard.anggota')
            ->where('jabatan', 'like', 'KORWIL%') // Menambahkan filter untuk jabatan Korwil
            ->latest()
            ->paginate(10);
        return view('admin.korwil.index', compact('korwils'));
    }

    /**
     * Menampilkan form untuk membuat data baru.
     */
    public function create()
    {
        // Ambil semua kartu anggota yang sudah memiliki card_id dan terhubung ke data anggota
        $anggotaCards = AnggotaCard::with('anggota')
            ->whereNotNull('card_id')
            ->whereHas('anggota')
            ->orderBy('id', 'desc')
            ->get();

        // Daftar provinsi di Indonesia
        $provinces = [
            'ACEH',
            'SUMATERA UTARA',
            'SUMATERA BARAT',
            'RIAU',
            'JAMBI',
            'SUMATERA SELATAN',
            'BENGKULU',
            'LAMPUNG',
            'KEPULAUAN BANGKA BELITUNG',
            'KEPULAUAN RIAU',
            'DKI JAKARTA',
            'JAWA BARAT',
            'JAWA TENGAH',
            'DI YOGYAKARTA',
            'JAWA TIMUR',
            'BANTEN',
            'BALI',
            'NUSA TENGGARA BARAT',
            'NUSA TENGGARA TIMUR',
            'KALIMANTAN BARAT',
            'KALIMANTAN TENGAH',
            'KALIMANTAN SELATAN',
            'KALIMANTAN TIMUR',
            'KALIMANTAN UTARA',
            'SULAWESI UTARA',
            'SULAWESI TENGAH',
            'SULAWESI SELATAN',
            'SULAWESI TENGGARA',
            'GORONTALO',
            'SULAWESI BARAT',
            'MALUKU',
            'MALUKU UTARA',
            'PAPUA BARAT',
            'PAPUA',
        ];

        return view('admin.korwil.create', compact('anggotaCards', 'provinces'));
    }

    /**
     * Menyimpan data baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Ubah 'anggota_cards' menjadi nama tabel yang sesuai di database Anda, misal: 'anggota_card'
            'anggota_card_id' => 'required|exists:anggota_card,id',
            'diterbitkan'     => 'required|date',
            'berlaku'         => 'required|date',
            'status_kartu'    => 'required|string|max:50',
            'jabatan'         => 'nullable|string|max:100',
            'keterangan'      => 'nullable|string',
        ]);

        AnggotaBerlaku::create($validated);

        return redirect()->route('admin.korwil.index')->with('success', 'Data Anggota Berlaku berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data.
     */
    public function edit(AnggotaBerlaku $korwil)
    {
        return view('admin.korwil.edit', compact('korwil'));
    }

    /**
     * Memperbarui data di database.
     */
    public function update(Request $request, AnggotaBerlaku $korwil)
    {
        $validated = $request->validate([
            'anggota_card_id' => 'required|exists:anggota_cards,id',
            'diterbitkan'     => 'required|date',
            'berlaku'         => 'required|date',
            'status_kartu'    => 'required|string|max:50',
            'jabatan'         => 'nullable|string|max:100',
            'keterangan'      => 'nullable|string',
        ]);

        $korwil->update($validated);

        return redirect()->route('admin.korwil.index')->with('success', 'Data Anggota Berlaku berhasil diperbarui.');
    }

    /**
     * Menghapus data dari database.
     */
    public function destroy(AnggotaBerlaku $korwil)
    {
        $korwil->delete();

        return redirect()->route('admin.korwil.index')->with('success', 'Data Anggota Berlaku berhasil dihapus.');
    }

    /**
     * Mengambil data AnggotaBerlaku terakhir untuk sebuah AnggotaCard.
     * Digunakan untuk auto-fill form.
     */
    public function getLatestKorwilData(AnggotaCard $anggotaCard)
    {
        // Cari data AnggotaBerlaku terakhir yang terhubung dengan AnggotaCard ini
        $latestData = AnggotaBerlaku::where('anggota_card_id', $anggotaCard->id)
            ->latest('id')
            ->first();

        return response()->json([
            'data' => $latestData
        ]);
    }
}
