<?php

namespace App\Policies;

use App\Models\Cari;
use App\Models\User;

class CariPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Kullanıcı en az bir firmaya erişimi varsa görebilir
        return $user->firmas()->exists();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Cari $cari): bool
    {
        // Kullanıcı carinin firmasına erişebiliyorsa görebilir
        return $user->hasAccessToFirma($cari->firma_id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Kullanıcı aktif bir firmaya sahipse oluşturabilir
        return session()->has('current_firma_id') && 
               $user->hasAccessToFirma(session('current_firma_id'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Cari $cari): bool
    {
        // Kullanıcı carinin firmasına erişebiliyorsa güncelleyebilir
        return $user->hasAccessToFirma($cari->firma_id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Cari $cari): bool
    {
        // Kullanıcı carinin firmasına erişebiliyorsa silebilir
        return $user->hasAccessToFirma($cari->firma_id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Cari $cari): bool
    {
        return $user->hasAccessToFirma($cari->firma_id);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Cari $cari): bool
    {
        return $user->hasAccessToFirma($cari->firma_id);
    }
}
