<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\AnggotaPembayaran;
use App\Models\Kerjasama;
use App\Models\PelatihanPembayaran;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SecureFileController extends Controller
{
    public function anggota(Request $request, Anggota $anggota, string $type): StreamedResponse
    {
        abort_unless(in_array($type, ['foto', 'foto_ktp', 'pakta_integritas'], true), 404);
        $this->allowOwnerOrAdmin($request, $anggota->user_id);

        return $this->download($anggota->{$type});
    }

    public function anggotaPayment(Request $request, AnggotaPembayaran $pembayaran): StreamedResponse
    {
        $pembayaran->load('anggotaCard.anggota');
        $this->allowOwnerOrAdmin($request, $pembayaran->anggotaCard?->anggota?->user_id);

        return $this->download($pembayaran->bukti_pembayaran);
    }

    public function pesanan(Request $request, Pesanan $pesanan): StreamedResponse
    {
        $this->allowOwnerOrAdmin($request, $pesanan->user_id);
        return $this->download($pesanan->bukti_pembayaran);
    }

    public function kerjasama(Request $request, Kerjasama $kerjasama): StreamedResponse
    {
        $this->allowOwnerOrAdmin($request, $kerjasama->user_id);
        return $this->download($kerjasama->file_dokumen);
    }

    public function pelatihanPayment(Request $request, PelatihanPembayaran $pembayaran): StreamedResponse
    {
        $this->allowOwnerOrAdmin($request, $pembayaran->user_id);
        return $this->download($pembayaran->bukti_pembayaran);
    }

    private function download(?string $path): StreamedResponse
    {
        abort_if(!$path || !Storage::disk('local')->exists($path), 404);
        return Storage::disk('local')->response($path);
    }

    private function allowOwnerOrAdmin(Request $request, ?int $userId): void
    {
        abort_unless($request->user()->id === $userId || $request->user()->hasAnyRole(['Super Admin', 'Staff']), 403);
    }
}
