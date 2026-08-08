<?php

namespace App\Policies;

use App\Models\PelatihanAnggota;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PelatihanAnggotaPolicy
{
    /**
     * Perform pre-authorization checks.
     *
     * @param  \App\Models\User  $user
     * @param  string  $ability
     * @return void|bool
     */
    public function before(User $user, string $ability)
    {
        // Berikan akses penuh ke Super Admin untuk semua tindakan
        if ($user->hasRole('Super Admin')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PelatihanAnggota $pelatihanAnggota): bool
    {
        // Izinkan jika user adalah pemilik pendaftaran
        return $user->id === $pelatihanAnggota->users_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Siapa pun yang login bisa mencoba mendaftar
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PelatihanAnggota $pelatihanAnggota): bool
    {
        // Izinkan jika user adalah pemilik pendaftaran
        return $user->id === $pelatihanAnggota->users_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PelatihanAnggota $pelatihanAnggota): bool
    {
        return false; // Secara default, user tidak bisa menghapus pendaftaran
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PelatihanAnggota $pelatihanAnggota): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PelatihanAnggota $pelatihanAnggota): bool
    {
        return false;
    }
}