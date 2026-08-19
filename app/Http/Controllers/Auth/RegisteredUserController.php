<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password'          => ['required', 'confirmed', Rules\Password::defaults()],
            'alamat'            => ['required', 'string'],
            'provinsi'          => ['required', 'string', 'max:255'],
            'kota'              => ['required', 'string', 'max:255'],
            'kecamatan'         => ['required', 'string', 'max:255'],
            'kelurahan'         => ['required', 'string', 'max:255'],
            'no_hp'             => ['required', 'string', 'max:20'],
            'jenis_kelamin'     => ['required', 'in:Laki-laki,Perempuan'],
            'tempat_lahir'      => ['required', 'string', 'max:255'],
            'tanggal_lahir'     => ['required', 'date'],
            'agama'             => ['required', 'string', 'max:50'],
            'status_perkawinan' => ['required', 'string', 'max:50'],
            'pekerjaan'         => ['required', 'string', 'max:100'],
            'kewarganegaraan'   => ['required', 'string', 'max:50'],
        ]);

        // Tambahkan password yang di-hash ke data yang divalidasi
        $validatedData['password'] = Hash::make($request->password);

        // Buat user baru dengan semua data yang divalidasi
        $user = User::create($validatedData);

        // PERBAIKAN: Otomatis berikan role 'Anggota' saat registrasi
        $user->assignRole('Anggota');

        event(new Registered($user));

        Auth::login($user);

        // Arahkan ke dashboard anggota setelah login
        return redirect(route('dashboard', absolute: false));
    }
}