<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetFirmaContext
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();

            // If user has no current_firma_id but belongs to at least one firm, set the first one
            if (!$user->current_firma_id && $user->firmas()->exists()) {
                $user->current_firma_id = $user->firmas()->first()->id;
                $user->save();
            }

            // Ensure the user actually belongs to the firm they are trying to access
            if ($user->current_firma_id && !$user->firmas()->where('firmas.id', $user->current_firma_id)->exists()) {
                // Reset or redirect to firm selection if they lost access
                $user->current_firma_id = null;
                $user->save();

                // If it's not the selection page itself, redirect
                if (!$request->routeIs('firmas.select')) {
                    return redirect()->route('firmas.select')->with('warning', 'Lütfen bir firma seçiniz.');
                }
            }
        }

        return $next($request);
    }
}
