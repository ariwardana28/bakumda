<?php

namespace App\Models\Concerns;

use Carbon\Carbon;

/**
 * Pakai di model Anggota:
 *
 *   use App\Models\Concerns\ChecksActiveMembership;
 *
 *   class Anggota extends Model
 *   {
 *       use ChecksActiveMembership;
 *       ...
 *   }
 *
 * Syarat anggota aktif:
 *   1. Punya kartu (anggota_card)
 *   2. Status terbaru kartu (anggota_status) termasuk daftar $activeStatuses
 *   3. Masa berlaku terbaru (anggota_berlaku): status_kartu = Aktif dan tanggal belum lewat
 */
trait ChecksActiveMembership
{
    /**
     * Sesuaikan dengan nilai yang benar-benar tersimpan di tabel anggota_status.
     */
    protected array $activeStatuses = ['AKTIF', 'APPROVED', 'DISETUJUI'];

    public function isActive(): bool
    {
        $card = $this->card;

        if (! $card) {
            return false;
        }

        $status = strtoupper(trim($card->latestStatus?->status ?? ''));

        if (! in_array($status, $this->activeStatuses, true)) {
            return false;
        }

        $berlaku = $card->latestBerlaku;

        if (! $berlaku) {
            return false;
        }

        if (strtoupper(trim($berlaku->status_kartu ?? '')) !== 'AKTIF') {
            return false;
        }

        // Hapus blok ini jika akses tetap diberikan walau kartu sudah kedaluwarsa.
        return Carbon::parse($berlaku->berlaku)->endOfDay()->isFuture();
    }
}