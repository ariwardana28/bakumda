<?php

namespace App\Services;

use App\Models\Banner;
use App\Models\Pelatihan;
use Illuminate\Support\Collection;

class HomepageBannerService
{
    public function activeSlides(): Collection
    {
        $banners = Banner::query()
            ->where('aktif', true)
            ->orderBy('urutan')
            ->orderBy('id')
            ->get();

        $pelatihanSlides = Pelatihan::query()
            ->where('tampilkan_di_banner', true)
            ->whereIn('status', ['akan datang', 'berlangsung'])
            ->whereNotNull('gambar')
            ->where('gambar', '!=', '')
            ->orderBy('tanggal_mulai')
            ->get()
            ->each(function (Pelatihan $pelatihan) {
                $pelatihan->tautan = route('user-pelatihan.show', $pelatihan);
            });

        return $banners->concat($pelatihanSlides);
    }
}