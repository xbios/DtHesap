<?php

namespace App\Policies;

use App\Models\Fatura;
use App\Models\User;

class FaturaPolicy
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
    public function view(User $user, Fatura $fatura): bool
    {
        return $user->hasAccessToFirma($fatura->firma_id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return session()->has('current_firma_id') && 
               $user->hasAccessToFirma(session('current_firma_id'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Fatura $fatura): bool
    {
        // Sadece beklemedeki faturaları güncelleyebilir
        if ($fatura->odeme_durum === 'tamamlandi') {
            return false;
        }
        
        return $user->hasAccessToFirma($fatura->firma_id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Fatura $fatura): bool
    {
        // Sadece beklemedeki faturaları silebilir
        if ($fatura->odeme_durum === 'tamamlandi') {
            return false;
        }
        
        return $user->hasAccessToFirma($fatura->firma_id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Fatura $fatura): bool
    {
        return $user->hasAccessToFirma($fatura->firma_id);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Fatura $fatura): bool
    {
        return $user->hasAccessToFirma($fatura->firma_id);
    }

    /**
     * Determine whether the user can add details to the invoice.
     */
    public function addDetail(User $user, Fatura $fatura): bool
    {
        if ($fatura->odeme_durum === 'tamamlandi') {
            return false;
        }
        
        return $user->hasAccessToFirma($fatura->firma_id);
    }
}
