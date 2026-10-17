<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public static function middleware(): array
    {
        return [
            'permission:pelatihan-view' => ['only' => ['index']],
            'permission:pelatihan-create' => ['only' => ['create', 'store']],
            'permission:pelatihan-edit' => ['only' => ['edit', 'update']],
            'permission:pelatihan-delete' => ['only' => ['destroy']],
        ];
    }

    public function index(Request $request)
    {
        $banners = Banner::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('judul', 'like', '%' . $request->string('search')->trim() . '%');
            })
            ->orderBy('urutan')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.banner.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banner.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'nullable|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'tautan' => 'nullable|string|max:2048',
            'urutan' => 'nullable|integer|min:0',
            'aktif' => 'required|boolean',
        ]);

        $validated['gambar'] = $request->file('gambar')->store('banners', 'public');
        $validated['urutan'] ??= 0;

        Banner::create($validated);

        return redirect()->route('admin.banner.index')->with('success', 'Banner berhasil ditambahkan.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banner.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'judul' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'tautan' => 'nullable|string|max:2048',
            'urutan' => 'nullable|integer|min:0',
            'aktif' => 'required|boolean',
        ]);

        if ($request->hasFile('gambar')) {
            Storage::disk('public')->delete($banner->gambar);
            $validated['gambar'] = $request->file('gambar')->store('banners', 'public');
        }

        $validated['urutan'] ??= 0;
        $banner->update($validated);

        return redirect()->route('admin.banner.index')->with('success', 'Banner berhasil diperbarui.');
    }

    public function destroy(Banner $banner)
    {
        Storage::disk('public')->delete($banner->gambar);
        $banner->delete();

        return redirect()->route('admin.banner.index')->with('success', 'Banner berhasil dihapus.');
    }
}