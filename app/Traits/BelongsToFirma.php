<?php

namespace App\Traits;

use App\Models\Firma;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait BelongsToFirma
{
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('firma', function (Builder $builder) {
            if (auth()->check() && auth()->user()->current_firma_id) {
                $builder->where('firma_id', auth()->user()->current_firma_id);
            }
        });

        static::creating(function (Model $model) {
            if (auth()->check() && auth()->user()->current_firma_id && !$model->firma_id) {
                $model->firma_id = auth()->user()->current_firma_id;
            }
        });
    }

    /**
     * Get the firma that owns the model.
     */
    public function firma()
    {
        return $this->belongsTo(Firma::class);
    }
}
