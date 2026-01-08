<?php

namespace App\Http\Controllers;

use App\Models\Banka;
use App\Models\Cari;
use App\Models\Fatura;
use App\Models\Kasa;
use App\Models\Stok;
use App\Models\KasaHareket;
use App\Models\BankaHareket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $currentMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // 1. Finansal Özet Kartları
        $kasaBakiyeleri = Kasa::active()->get()->sum('bakiye');
        $bankaBakiyeleri = Banka::active()->get()->sum('bakiye');
        $netLikidite = $kasaBakiyeleri + $bankaBakiyeleri;

        // Cari Bakiyeleri - HasFirmaScope zaten firma_id filtresini ekliyor
        $cariler = Cari::active()->get();
        $toplamAlacak = 0;
        $toplamBorc = 0;

        foreach ($cariler as $cari) {
            $bakiye = $cari->bakiye;
            if ($bakiye > 0) {
                $toplamAlacak += $bakiye;
            } elseif ($bakiye < 0) {
                $toplamBorc += abs($bakiye);
            }
        }

        // 2. Aylık Performans
        $buAySatis = Fatura::satis()
            ->whereBetween('tarih', [$currentMonth, $endOfMonth])
            ->sum('genel_toplam');

        $buAyAlis = Fatura::alis()
            ->whereBetween('tarih', [$currentMonth, $endOfMonth])
            ->sum('genel_toplam');

        // 3. Son İşlemler
        $sonFaturalar = Fatura::with('cari')
            ->latest()
            ->take(5)
            ->get();

        // Son Para Hareketleri (Kasa ve Banka Birleşik)
        $sonKasaHareketler = KasaHareket::with('kasa')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($h) {
                return [
                    'tarih' => $h->tarih,
                    'tur' => 'Kasa: ' . $h->kasa->ad,
                    'aciklama' => $h->aciklama,
                    'islem_tip' => $h->islem_tip,
                    'tutar' => $h->tutar,
                ];
            });

        $sonBankaHareketler = BankaHareket::with('banka')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($h) {
                return [
                    'tarih' => $h->tarih,
                    'tur' => 'Banka: ' . $h->banka->banka_adi,
                    'aciklama' => $h->aciklama,
                    'islem_tip' => $h->islem_tip,
                    'tutar' => $h->tutar,
                ];
            });

        $sonHareketler = $sonKasaHareketler->concat($sonBankaHareketler)
            ->sortByDesc('tarih')
            ->take(5);

        // 4. Kritik Uyarılar
        $kritikStoklar = Stok::lowStock()
            ->active()
            ->take(5)
            ->get();

        // 5. Grafik Verileri (Son 6 Ay)
        $grafikVerileri = $this->getMonthlyStats();

        return view('dashboard', compact(
            'netLikidite',
            'toplamAlacak',
            'toplamBorc',
            'buAySatis',
            'buAyAlis',
            'sonFaturalar',
            'sonHareketler',
            'kritikStoklar',
            'grafikVerileri'
        ));
    }

    private function getMonthlyStats()
    {
        $stats = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $start = (clone $date)->startOfMonth();
            $end = (clone $date)->endOfMonth();

            $satis = Fatura::satis()
                ->whereBetween('tarih', [$start, $end])
                ->sum('genel_toplam');

            $alis = Fatura::alis()
                ->whereBetween('tarih', [$start, $end])
                ->sum('genel_toplam');

            $stats[] = [
                'ay' => $date->translatedFormat('F'),
                'satis' => (float)$satis,
                'alis' => (float)$alis,
            ];
        }
        return $stats;
    }
}
