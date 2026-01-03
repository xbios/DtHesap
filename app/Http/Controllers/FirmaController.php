<?php

namespace App\Http\Controllers;

use App\Models\Firma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FirmaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Only show firmas the user belongs to
        $firmas = auth()->user()->firmas()->latest()->paginate(10);
        return view('firmas.index', compact('firmas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('firmas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kod' => 'required|string|max:50|unique:firmas,kod',
            'unvan' => 'required|string|max:255',
            'vergi_dairesi' => 'nullable|string|max:100',
            'vergi_no' => 'nullable|string|max:50',
            'adres' => 'nullable|string',
            'il' => 'nullable|string|max:100',
            'ilce' => 'nullable|string|max:100',
            'telefon' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $firma = Firma::create($validated);

            // Link user to the new firm as admin
            auth()->user()->firmas()->attach($firma->id, [
                'rol' => 'admin',
                'yetki_seviyesi' => 5
            ]);

            // If user has no current firma, set this one
            if (!auth()->user()->current_firma_id) {
                auth()->user()->update(['current_firma_id' => $firma->id]);
            }

            DB::commit();

            return redirect()->route('firmas.index')->with('success', 'Firma başarıyla oluşturuldu.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Firma oluşturulurken bir hata oluştu: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Firma $firma)
    {
        // Security check
        if (!auth()->user()->firmas->contains($firma->id)) {
            abort(403);
        }

        return view('firmas.show', compact('firma'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Firma $firma)
    {
        // Security check
        if (!auth()->user()->firmas->contains($firma->id)) {
            abort(403);
        }

        return view('firmas.edit', compact('firma'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Firma $firma)
    {
        // Security check
        if (!auth()->user()->firmas->contains($firma->id)) {
            abort(403);
        }

        $validated = $request->validate([
            'kod' => 'required|string|max:50|unique:firmas,kod,' . $firma->id,
            'unvan' => 'required|string|max:255',
            'vergi_dairesi' => 'nullable|string|max:100',
            'vergi_no' => 'nullable|string|max:50',
            'adres' => 'nullable|string',
            'il' => 'nullable|string|max:100',
            'ilce' => 'nullable|string|max:100',
            'telefon' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|string|max:255',
        ]);

        $firma->update($validated);

        return redirect()->route('firmas.index')->with('success', 'Firma başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Firma $firma)
    {
        // Security check
        if (!auth()->user()->firmas->contains($firma->id)) {
            abort(403);
        }

        // Logic here: Maybe we don't want to delete if it's the current active firma
        if (auth()->user()->current_firma_id == $firma->id) {
            return redirect()->back()->with('error', 'Aktif firmayı silemezsiniz. Lütfen önce başka bir firma seçin.');
        }

        $firma->delete();

        return redirect()->route('firmas.index')->with('success', 'Firma başarıyla silindi.');
    }
}
