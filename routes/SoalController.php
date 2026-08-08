<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Materi $materi)
    {
        $soalList = $materi->soal()->with('jawaban')->latest()->paginate(10);
        return view('admin.soal.index', compact('materi', 'soalList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Materi $materi)
    {
        return view('admin.soal.create', compact('materi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Materi $materi)
    {
        $validated = $request->validate([
            'soal' => 'required|string',
            'jawaban' => 'required|array|min:5|max:5',
            'jawaban.*' => 'required|string',
            'jawaban_benar' => 'required|integer|in:0,1,2,3,4',
        ]);

        DB::beginTransaction();
        try {
            $soal = $materi->soal()->create([
                'soal' => $validated['soal'],
            ]);

            foreach ($validated['jawaban'] as $index => $jawabanText) {
                $soal->jawaban()->create([
                    'jawaban' => $jawabanText,
                    'status' => $index == $validated['jawaban_benar'],
                ]);
            }

            DB::commit();
            return redirect()->route('admin.materi.soal.index', $materi->id)
                ->with('success', 'Soal dan jawaban berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan soal: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Materi $materi, Soal $soal)
    {
        // Eager load jawaban dan juga kolom jawaban_benar_id
        $soal->load('jawaban'); 
        return view('admin.soal.edit', compact('materi', 'soal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Materi $materi, Soal $soal)
    {
        $validated = $request->validate([
            'soal' => 'required|string',
            'jawaban' => 'required|array|min:5|max:5',
            'jawaban.*.id' => 'required|exists:jawaban,id',
            'jawaban.*.text' => 'required|string',
            'jawaban_benar' => 'required|exists:jawaban,id',
        ]);

        DB::beginTransaction();
        try {
            $soal->update(['soal' => $validated['soal']]);

            // Reset semua jawaban untuk soal ini
            $soal->jawaban()->update(['status' => false]);

            foreach ($validated['jawaban'] as $jawabanData) {
                $jawaban = \App\Models\Jawaban::find($jawabanData['id']);
                if ($jawaban && $jawaban->soal_id === $soal->id) {
                    $jawaban->update([
                        'jawaban' => $jawabanData['text'],
                        'status' => $jawaban->id == $validated['jawaban_benar'],
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.materi.soal.index', $materi->id)
                ->with('success', 'Soal dan jawaban berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui soal: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Materi $materi, Soal $soal)
    {
        try {
            // onDelete('cascade') pada migrasi akan otomatis menghapus jawaban terkait
            $soal->delete();
            return redirect()->route('admin.materi.soal.index', $materi->id)
                ->with('success', 'Soal berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus soal: ' . $e->getMessage());
        }
    }
}