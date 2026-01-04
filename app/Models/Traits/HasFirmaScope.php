<?php

namespace App\Models\Traits;

use App\Models\Scopes\FirmaScope;
use Illuminate\Database\Eloquent\Model;

trait HasFirmaScope
{
    /**
     * Boot the HasFirmaScope trait for a model.
     */
    protected static function bootHasFirmaScope(): void
    {
        static::addGlobalScope(new FirmaScope);
        
        // Yeni kayıt oluşturulurken otomatik firma_id ata
        static::creating(function (Model $model) {
            if (!$model->firma_id && session()->has('current_firma_id')) {
                $model->firma_id = session('current_firma_id');
            }
        });
    }
}
