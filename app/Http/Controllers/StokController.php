<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\StokKategori;
use App\Http\Requests\StoreStokRequest;
use App\Http\Requests\UpdateStokRequest;
use Illuminate\Http\Request;

class StokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Stok::with('kategori');

        // Arama
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ad', 'like', "%{$search}%")
                    ->orWhere('kod', 'like', "%{$search}%")
                    ->orWhere('barkod', 'like', "%{$search}%");
            });
        }

        // Kategori Filtresi
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Sayfalama
        $stoklar = $query->latest()->paginate($request->get('per_page', 15));

        $kategoriler = StokKategori::all();

        return view('stok.index', compact('stoklar', 'kategoriler'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoriler = StokKategori::all();
        return view('stok.create', compact('kategoriler'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStokRequest $request)
    {
        try {
            $stok = Stok::create($request->validated());
            return redirect()->route('stoks.index')->with('success', 'Stok kartı başarıyla oluşturuldu.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Stok kaydedilirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Stok $stok)
    {
        $stok->load([
            'kategori',
            'hareketler' => function ($q) {
                $q->latest()->limit(20);
            }
        ]);

        return view('stok.show', compact('stok'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stok $stok)
    {
        $kategoriler = StokKategori::all();
        return view('stok.edit', compact('stok', 'kategoriler'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStokRequest $request, Stok $stok)
    {
        try {
            $stok->update($request->validated());
            return redirect()->route('stoks.index')->with('success', 'Stok kartı başarıyla güncellendi.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Stok güncellenirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stok $stok)
    {
        try {
            $stok->delete();
            return redirect()->route('stoks.index')->with('success', 'Stok kartı başarıyla silindi.');
        } catch (\Exception $e) {
            return back()->with('error', 'Stok silinirken bir hata oluştu.');
        }
    }
}
