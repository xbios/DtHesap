<?php

namespace App\Http\Controllers;

use App\Models\Banka;
use Illuminate\Http\Request;

class BankaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Banka::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('banka_adi', 'like', "%{$search}%")
                    ->orWhere('hesap_no', 'like', "%{$search}%")
                    ->orWhere('iban', 'like', "%{$search}%")
                    ->orWhere('kod', 'like', "%{$search}%");
            });
        }

        $bankalar = $query->latest()->paginate($request->get('per_page', 15));

        return view('banka.index', compact('bankalar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('banka.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kod' => 'required|string|max:50',
            'banka_adi' => 'required|string|max:100',
            'sube_adi' => 'nullable|string|max:100',
            'sube_kodu' => 'nullable|string|max:50',
            'hesap_no' => 'required|string|max:50',
            'iban' => 'nullable|string|max:50',
            'doviz_tip' => 'required|string|max:3',
            'aciklama' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        try {
            Banka::create($validated);
            return redirect()->route('bankas.index')->with('success', 'Banka hesabı başarıyla oluşturuldu.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Banka hesabı kaydedilirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Banka $banka)
    {
        $banka->load([
            'hareketler' => function ($q) {
                $q->latest()->limit(20);
            }
        ]);

        return view('banka.show', compact('banka'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banka $banka)
    {
        return view('banka.edit', compact('banka'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banka $banka)
    {
        $validated = $request->validate([
            'kod' => 'required|string|max:50',
            'banka_adi' => 'required|string|max:100',
            'sube_adi' => 'nullable|string|max:100',
            'sube_kodu' => 'nullable|string|max:50',
            'hesap_no' => 'required|string|max:50',
            'iban' => 'nullable|string|max:50',
            'doviz_tip' => 'required|string|max:3',
            'aciklama' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        try {
            $banka->update($validated);
            return redirect()->route('bankas.index')->with('success', 'Banka hesabı başarıyla güncellendi.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Banka hesabı güncellenirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banka $banka)
    {
        try {
            $banka->delete();
            return redirect()->route('bankas.index')->with('success', 'Banka hesabı başarıyla silindi.');
        } catch (\Exception $e) {
            return back()->with('error', 'Banka hesabı silinirken bir hata oluştu.');
        }
    }
}
