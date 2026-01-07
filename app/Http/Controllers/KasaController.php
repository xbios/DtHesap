<?php

namespace App\Http\Controllers;

use App\Models\Kasa;
use Illuminate\Http\Request;

class KasaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Kasa::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ad', 'like', "%{$search}%")
                    ->orWhere('kod', 'like', "%{$search}%");
            });
        }

        $kasalar = $query->latest()->paginate($request->get('per_page', 15));

        return view('kasa.index', compact('kasalar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kasa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kod' => 'required|string|max:50',
            'ad' => 'required|string|max:100',
            'doviz_tip' => 'required|string|max:3',
            'aciklama' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        try {
            Kasa::create($validated);
            return redirect()->route('kasas.index')->with('success', 'Kasa başarıyla oluşturuldu.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Kasa kaydedilirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Kasa $kasa)
    {
        $kasa->load([
            'hareketler' => function ($q) {
                $q->latest()->limit(20);
            }
        ]);

        return view('kasa.show', compact('kasa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kasa $kasa)
    {
        return view('kasa.edit', compact('kasa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kasa $kasa)
    {
        $validated = $request->validate([
            'kod' => 'required|string|max:50',
            'ad' => 'required|string|max:100',
            'doviz_tip' => 'required|string|max:3',
            'aciklama' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        try {
            $kasa->update($validated);
            return redirect()->route('kasas.index')->with('success', 'Kasa başarıyla güncellendi.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Kasa güncellenirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kasa $kasa)
    {
        try {
            $kasa->delete();
            return redirect()->route('kasas.index')->with('success', 'Kasa başarıyla silindi.');
        } catch (\Exception $e) {
            return back()->with('error', 'Kasa silinirken bir hata oluştu.');
        }
    }
}
