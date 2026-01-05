<?php

namespace App\Http\Controllers;

use App\Models\Cari;
use App\Http\Resources\CariResource;
use App\Http\Resources\CariHareketResource;
use App\Http\Requests\StoreCariRequest;
use App\Http\Requests\UpdateCariRequest;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CariController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $this->authorize('viewAny', Cari::class);

        $query = Cari::with('firma');

        // Filtreleme
        if ($request->has('tip')) {
            $query->where('tip', $request->tip);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('unvan', 'like', "%{$search}%")
                  ->orWhere('kod', 'like', "%{$search}%");
            });
        }

        // Sıralama
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Sayfalama
        $perPage = $request->get('per_page', 15);
        $cariler = $query->paginate($perPage);

        return view('cari.index', compact('cariler'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cari.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCariRequest $request)
    {
        // $this->authorize('create', Cari::class);

        if (!session()->has('current_firma_id')) {
            return back()->withInput()->with('error', 'İşlem yapabilmek için seçili bir firmanız olmalıdır.');
        }

        try {
            $cari = Cari::create($request->validated());
            return redirect()->route('caris.index')->with('success', 'Cari başarıyla oluşturuldu');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Cari oluşturulurken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cari $cari)
    {
        // $this->authorize('view', $cari);

        return new CariResource($cari->load(['firma', 'hareketler' => function($q) {
            $q->latest()->limit(10);
        }]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cari $cari)
    {
        return view('cari.edit', compact('cari'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCariRequest $request, Cari $cari)
    {
        // $this->authorize('update', $cari);

        $cari->update($request->validated());

        return redirect()->route('caris.index')->with('success', 'Cari başarıyla güncellendi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cari $cari)
    {
        // $this->authorize('delete', $cari);

        $cari->delete();

        return redirect()->route('caris.index')->with('success', 'Cari başarıyla silindi');
    }

    /**
     * Get cari balance
     */
    public function balance(Cari $cari)
    {
        return response()->json([
            'cari_id' => $cari->id,
            'unvan' => $cari->unvan,
            'bakiye' => $cari->bakiye,
        ]);
    }

    /**
     * Get cari movements
     */
    public function movements(Request $request, Cari $cari)
    {
        $query = $cari->hareketler()->with('evrak');

        // Tarih filtresi
        if ($request->has('start_date')) {
            $query->where('tarih', '>=', $request->start_date);
        }
        if ($request->has('end_date')) {
            $query->where('tarih', '<=', $request->end_date);
        }

        $hareketler = $query->orderBy('tarih', 'desc')->paginate(20);

        return CariHareketResource::collection($hareketler);
    }
}
