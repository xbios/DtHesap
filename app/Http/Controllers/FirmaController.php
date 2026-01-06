<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FirmaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $firmalar = auth()->user()->firmas()->paginate(10);
        return view('firma.index', compact('firmalar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('firma.create');
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
            'email' => 'nullable|email|max:255',
            'telefon' => 'nullable|string|max:50',
            'adres' => 'nullable|string',
            'il' => 'nullable|string|max:100',
            'ilce' => 'nullable|string|max:100',
        ]);

        $firma = \App\Models\Firma::create($validated);

        // Kullanıcıyı firmaya bağla
        auth()->user()->firmas()->attach($firma->id, [
            'rol' => 'admin',
            'yetki_seviyesi' => 10,
        ]);

        return redirect()->route('firmas.index')->with('success', 'Firma başarıyla oluşturuldu.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $firma = auth()->user()->firmas()->findOrFail($id);
        return view('firma.show', compact('firma'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $firma = auth()->user()->firmas()->findOrFail($id);
        return view('firma.edit', compact('firma'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $firma = auth()->user()->firmas()->findOrFail($id);

        $validated = $request->validate([
            'kod' => 'required|string|max:50|unique:firmas,kod,' . $id,
            'unvan' => 'required|string|max:255',
            'vergi_dairesi' => 'nullable|string|max:100',
            'vergi_no' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'telefon' => 'nullable|string|max:50',
            'adres' => 'nullable|string',
            'il' => 'nullable|string|max:100',
            'ilce' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        $firma->update($validated);

        return redirect()->route('firmas.index')->with('success', 'Firma başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $firma = auth()->user()->firmas()->findOrFail($id);

        // Aktif firmayı siliyorsa oturumdan temizle
        if (current_firma_id() == $firma->id) {
            session()->forget('current_firma_id');
        }

        $firma->delete();

        return redirect()->route('firmas.index')->with('success', 'Firma başarıyla silindi.');
    }

    /**
     * Switch to another firma
     */
    public function switch(string $id)
    {
        if (switch_firma((int) $id)) {
            return back()->with('success', 'Firma başarıyla değiştirildi.');
        }

        return back()->with('error', 'Bu firmaya erişim yetkiniz bulunmamaktadır.');
    }
}
