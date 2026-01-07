<?php

namespace App\Observers;

use App\Models\Cari;
use App\Models\ActivityLog;

class CariObserver
{
    /**
     * Handle the Cari "created" event.
     */
    public function created(Cari $cari): void
    {
        ActivityLog::log(
            'Cari',
            'created',
            "Yeni cari kartı oluşturuldu: {$cari->unvan} ({$cari->kod})",
            ['cari_id' => $cari->id, 'kod' => $cari->kod, 'unvan' => $cari->unvan]
        );
    }

    /**
     * Handle the Cari "updated" event.
     */
    public function updated(Cari $cari): void
    {
        ActivityLog::log(
            'Cari',
            'updated',
            "Cari kartı güncellendi: {$cari->unvan}",
            ['cari_id' => $cari->id, 'changes' => $cari->getChanges()]
        );
    }

    /**
     * Handle the Cari "deleted" event.
     */
    public function deleted(Cari $cari): void
    {
        ActivityLog::log(
            'Cari',
            'deleted',
            "Cari kartı silindi: {$cari->unvan}",
            ['cari_id' => $cari->id, 'unvan' => $cari->unvan]
        );
    }
}
