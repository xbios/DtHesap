<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetCurrentFirma
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            
            // Kullanıcının session'ında firma yoksa ilk firmasını ata
            if (!session()->has('current_firma_id')) {
                $firstFirma = $user->firmas()->first();
                if ($firstFirma) {
                    session(['current_firma_id' => $firstFirma->id]);
                }
            }
            
            // Kullanıcının seçili firmaya erişimi var mı kontrol et
            $currentFirmaId = session('current_firma_id');
            if ($currentFirmaId && !$user->hasAccessToFirma($currentFirmaId)) {
                // Erişim yoksa ilk firmaya geç
                $firstFirma = $user->firmas()->first();
                if ($firstFirma) {
                    session(['current_firma_id' => $firstFirma->id]);
                } else {
                    session()->forget('current_firma_id');
                }
            }
        }
        
        return $next($request);
    }
}

