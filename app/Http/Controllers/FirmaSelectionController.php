<?php

namespace App\Http\Controllers;

use App\Models\Firma;
use Illuminate\Http\Request;

class FirmaSelectionController extends Controller
{
    /**
     * Show the firm selection page.
     */
    public function index()
    {
        $firmas = auth()->user()->firmas;

        // If user has only one firm, redirect to dashboard directly (optional, but good UX)
        /*
        if ($firmas->count() === 1) {
            return $this->select($firmas->first()->id);
        }
        */

        return view('firmas.select', compact('firmas'));
    }

    /**
     * Select a firm and update the user's current_firma_id.
     */
    public function select($id)
    {
        $user = auth()->user();

        // Ensure user belongs to this firm
        if (!$user->firmas()->where('firmas.id', $id)->exists()) {
            return redirect()->back()->with('error', 'Bu firmaya erişim yetkiniz yok.');
        }

        $user->current_firma_id = $id;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Firma başarıyla seçildi.');
    }
}
