<?php

namespace App\Observers;

use App\Models\Stok;
use App\Models\ActivityLog;

class StokObserver
{
    /**
     * Handle the Stok "created" event.
     */
    public function created(Stok $stok): void
    {
        ActivityLog::log(
            'Stok',
            'created',
            "Yeni stok kartı oluşturuldu: {$stok->ad} ({$stok->kod})",
            ['stok_id' => $stok->id, 'kod' => $stok->kod, 'ad' => $stok->ad]
        );
    }

    /**
     * Handle the Stok "updated" event.
     */
    public function updated(Stok $stok): void
    {
        ActivityLog::log(
            'Stok',
            'updated',
            "Stok kartı güncellendi: {$stok->ad}",
            ['stok_id' => $stok->id, 'changes' => $stok->getChanges()]
        );
    }

    /**
     * Handle the Stok "deleted" event.
     */
    public function deleted(Stok $stok): void
    {
        ActivityLog::log(
            'Stok',
            'deleted',
            "Stok kartı silindi: {$stok->ad}",
            ['stok_id' => $stok->id, 'ad' => $stok->ad]
        );
    }
}
