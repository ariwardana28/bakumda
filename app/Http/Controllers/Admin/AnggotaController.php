<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\AnggotaCard;
use App\Models\AnggotaStatus;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;


class AnggotaController extends Controller
{
    /**
     * Menerapkan middleware permission untuk setiap aksi pada resource Anggota.
     */
    public static function middleware(): array
    {
        return [
            'permission:anggota-view'   => ['only' => ['index', 'show']],
            'permission:anggota-create' => ['only' => ['create', 'store']],
            'permission:anggota-edit'   => ['only' => ['edit', 'update']],
            'permission:anggota-delete' => ['only' => ['destroy']],
        ];
    }

    public function index()
    {
        $anggotas = Anggota::latest()->paginate(10);
        return view('admin.anggota.index', compact('anggotas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.anggota.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_ktp' => 'nullable|string|max:255|unique:anggota,no_ktp',
            'alamat' => 'nullable|string',
            'provinsi' => 'nullable|string|max:255',
            'kota' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kelurahan' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:anggota,email',
            'jenis_kelamin' => 'nullable|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'agama' => 'nullable|string|max:255',
            'status_perkawinan' => 'nullable|string|max:255',
            'pekerjaan' => 'nullable|string|max:255',
            'kewarganegaraan' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pakta_integritas' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('anggota/foto', 'public');
        }
        if ($request->hasFile('foto_ktp')) {
            $validated['foto_ktp'] = $request->file('foto_ktp')->store('anggota/foto_ktp', 'public');
        }
        if ($request->hasFile('pakta_integritas')) {
            $validated['pakta_integritas'] = $request->file('pakta_integritas')->store('anggota/pakta_integritas', 'public');
        }

        // Simpan data anggota ke database
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

        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Anggota $anggota)
    {
        return view('admin.anggota.show', compact('anggota'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Anggota $anggota)
    {
        return view('admin.anggota.edit', compact('anggota'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Anggota $anggota)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'card_id' => 'nullable|string|max:255|unique:anggota,card_id,' . $anggota->id,
            'no_ktp' => 'nullable|string|max:255|unique:anggota,no_ktp,' . $anggota->id,
            'alamat' => 'nullable|string',
            'provinsi' => 'nullable|string|max:255',
            'kota' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kelurahan' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:anggota,email,' . $anggota->id,
            'jenis_kelamin' => 'nullable|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'agama' => 'nullable|string|max:255',
            'status_perkawinan' => 'nullable|string|max:255',
            'pekerjaan' => 'nullable|string|max:255',
            'kewarganegaraan' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pakta_integritas' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string',
            'status' => 'nullable|string|max:255',
            'diterbitkan' => 'nullable|string|max:255',
            'berlaku' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($anggota->foto) {
                Storage::disk('public')->delete($anggota->foto);
            }
            $validated['foto'] = $request->file('foto')->store('anggota/foto', 'public');
        }

        if ($request->hasFile('foto_ktp')) {
            // Hapus foto ktp lama jika ada
            if ($anggota->foto_ktp) {
                Storage::disk('public')->delete($anggota->foto_ktp);
            }
            $validated['foto_ktp'] = $request->file('foto_ktp')->store('anggota/foto_ktp', 'public');
        }

        if ($request->hasFile('pakta_integritas')) {
            // Logika untuk menghapus file lama bisa ditambahkan di sini jika perlu
            $validated['pakta_integritas'] = $request->file('pakta_integritas')->store('anggota/pakta_integritas', 'public');
        }

        $anggota->update($validated);

        return redirect()->route('admin.anggota.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anggota $anggota)
    {
        // Hapus foto jika ada
        if ($anggota->foto) {
            Storage::disk('public')->delete($anggota->foto);
        }
        if ($anggota->foto_ktp) {
            Storage::disk('public')->delete($anggota->foto_ktp);
        }
        if ($anggota->pakta_integritas) {
            Storage::disk('public')->delete($anggota->pakta_integritas);
        }

        $anggota->delete();

        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil dihapus.');
    }

    
}
