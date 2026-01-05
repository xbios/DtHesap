<?php

namespace App\Policies;

use App\Models\Firma;
use App\Models\User;

class FirmaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->firmas()->exists();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Firma $firma): bool
    {
        return $user->hasAccessToFirma($firma->id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Sadece süper adminler yeni firma oluşturabilir
        // Bu özellik ileride eklenebilir
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Firma $firma): bool
    {
        // Kullanıcının firmaya erişimi varsa ve admin rolündeyse güncelleyebilir
        $pivot = $user->firmas()->where('firma_id', $firma->id)->first()?->pivot;
        
        return $pivot && $pivot->rol === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Firma $firma): bool
    {
        // Sadece süper adminler firma silebilir
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Firma $firma): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Firma $firma): bool
    {
        return false;
    }

    /**
     * Determine whether the user can switch to this firma.
     */
    public function switch(User $user, Firma $firma): bool
    {
        return $user->hasAccessToFirma($firma->id);
    }
}
