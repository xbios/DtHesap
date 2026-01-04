<?php

use App\Models\Firma;

if (!function_exists('current_firma_id')) {
    /**
     * Get current firma ID from session
     */
    function current_firma_id(): ?int
    {
        return session('current_firma_id');
    }
}

if (!function_exists('current_firma')) {
    /**
     * Get current firma model
     */
    function current_firma(): ?Firma
    {
        $firmaId = current_firma_id();
        return $firmaId ? Firma::find($firmaId) : null;
    }
}

if (!function_exists('switch_firma')) {
    /**
     * Switch to another firma
     */
    function switch_firma(int $firmaId): bool
    {
        if (auth()->check() && auth()->user()->hasAccessToFirma($firmaId)) {
            session(['current_firma_id' => $firmaId]);
            return true;
        }
        return false;
    }
}
