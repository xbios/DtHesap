<?php

namespace App\Http\Controllers;

use App\Models\Fatura;
use App\Models\FaturaDetay;
use App\Http\Resources\FaturaResource;
use App\Http\Resources\FaturaDetayResource;
use App\Http\Requests\StoreFaturaRequest;
use App\Http\Requests\UpdateFaturaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class FaturaController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Fatura::class);

        $query = Fatura::with(['cari', 'detaylar']);

        // Filtreleme
        if ($request->has('fatura_tip')) {
            $query->where('fatura_tip', $request->fatura_tip);
        }

        if ($request->has('odeme_durum')) {
            $query->where('odeme_durum', $request->odeme_durum);
        }

        if ($request->has('cari_id')) {
            $query->where('cari_id', $request->cari_id);
        }

        if ($request->has('start_date')) {
            $query->where('tarih', '>=', $request->start_date);
        }

        if ($request->has('end_date')) {
            $query->where('tarih', '<=', $request->end_date);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('fatura_no', 'like', "%{$search}%")
                  ->orWhereHas('cari', function($q) use ($search) {
                      $q->where('unvan', 'like', "%{$search}%");
                  });
            });
        }

        // Sıralama
        $sortBy = $request->get('sort_by', 'tarih');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Sayfalama
        $perPage = $request->get('per_page', 15);
        $faturalar = $query->paginate($perPage);

        return view('fatura.index', compact('faturalar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fatura.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFaturaRequest $request)
    {
        // $this->authorize('create', Fatura::class);

        if (!session()->has('current_firma_id')) {
            return back()->withInput()->with('error', 'İşlem yapabilmek için seçili bir firmanız olmalıdır.');
        }

        $validated = $request->validated();

        DB::beginTransaction();
        try {
            // Fatura oluştur
            $fatura = Fatura::create([
                'cari_id' => $validated['cari_id'],
                'fatura_no' => $validated['fatura_no'],
                'fatura_tip' => $validated['fatura_tip'],
                'tarih' => $validated['tarih'],
                'vade_tarih' => $validated['vade_tarih'] ?? null,
                'doviz_tip' => $validated['doviz_tip'],
                'doviz_kur' => $validated['doviz_kur'],
                'odeme_durum' => $validated['odeme_durum'],
                'aciklama' => $validated['aciklama'] ?? null,
                'created_by' => auth()->id(),
            ]);

            // Detayları ekle
            foreach ($validated['detaylar'] as $index => $detayData) {
                $detay = $fatura->detaylar()->create([
                    'stok_id' => $detayData['stok_id'] ?? null,
                    'aciklama' => $detayData['aciklama'],
                    'miktar' => $detayData['miktar'],
                    'birim' => $detayData['birim'],
                    'birim_fiyat' => $detayData['birim_fiyat'],
                    'kdv_oran' => $detayData['kdv_oran'],
                    'indirim_oran' => $detayData['indirim_oran'] ?? 0,
                    'sira' => $index + 1,
                ]);

                $detay->calculateTotals();
            }

            // Toplamları hesapla
            $fatura->calculateTotals();

            DB::commit();

            return redirect()->route('faturas.index')->with('success', 'Fatura başarıyla oluşturuldu');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Fatura oluşturulurken hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Fatura $fatura)
    {
        // $this->authorize('view', $fatura);

        return view('fatura.show', [
            'fatura' => $fatura->load([
                'cari',
                'detaylar.stok',
                'creator',
                'cariHareket',
                'stokHareketler.stok'
            ])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fatura $fatura)
    {
        return view('fatura.edit', compact('fatura'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFaturaRequest $request, Fatura $fatura)
    {
        // $this->authorize('update', $fatura);

        $fatura->update($request->validated());

        return redirect()->route('faturas.index')->with('success', 'Fatura başarıyla güncellendi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fatura $fatura)
    {
        // $this->authorize('delete', $fatura);

        $fatura->delete();

        return redirect()->route('faturas.index')->with('success', 'Fatura başarıyla silindi');
    }

    /**
     * Add detail to invoice
     */
    public function addDetail(Request $request, Fatura $fatura)
    {
        $this->authorize('addDetail', $fatura);

        $validated = $request->validate([
            'stok_id' => 'nullable|exists:stoks,id',
            'aciklama' => 'required|string',
            'miktar' => 'required|numeric|min:0.01',
            'birim' => 'required|string|max:20',
            'birim_fiyat' => 'required|numeric|min:0',
            'kdv_oran' => 'required|numeric|min:0|max:100',
            'indirim_oran' => 'nullable|numeric|min:0|max:100',
        ]);

        $maxSira = $fatura->detaylar()->max('sira') ?? 0;

        $detay = $fatura->detaylar()->create([
            ...$validated,
            'sira' => $maxSira + 1,
        ]);

        $detay->calculateTotals();
        $fatura->calculateTotals();

        return (new FaturaDetayResource($detay->load('stok')))
            ->additional(['message' => 'Detay başarıyla eklendi'])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Remove detail from invoice
     */
    public function removeDetail(Fatura $fatura, FaturaDetay $detay)
    {
        if ($detay->fatura_id !== $fatura->id) {
            return response()->json([
                'message' => 'Bu detay bu faturaya ait değil'
            ], 403);
        }

        $detay->delete();

        return response()->json([
            'message' => 'Detay başarıyla silindi'
        ]);
    }
}
