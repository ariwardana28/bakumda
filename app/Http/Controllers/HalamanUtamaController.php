<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelatihan;
use App\Models\Anggota;
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class HalamanUtamaController extends Controller
{
    public function index()
    {
        $pelatihans = Pelatihan::latest()->get();
        $user = Auth::user();

        $isRegistered = false;
        $nama_anggota = '';
        $no_ktpa = '';
        $status_anggota = '';

        // Cari anggota berdasarkan user_id yang sedang login
        $anggota = Anggota::where('user_id', $user->id ?? null)->first();

        if ($anggota) {
            $card = $anggota->card; // Mengambil relasi card dari model
            if ($card) {
                $isRegistered = true;
                $nama_anggota = $anggota->nama;
                $no_ktpa = $card->card_id; // Sesuai dengan kolom di tabel anggota_card

                // Mengambil status terbaru menggunakan accessor dari model Anda
                $latestStatus = $anggota->latest_status;
                $status_anggota = $latestStatus ? $latestStatus->status : 'Menunggu Verifikasi';
            }
        }

        return view('welcome', compact('pelatihans', 'isRegistered', 'nama_anggota', 'no_ktpa', 'status_anggota'));
    }
}
