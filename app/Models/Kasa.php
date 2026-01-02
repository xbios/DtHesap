<?php

namespace App\Models;

use App\Traits\BelongsToFirma;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kasa extends Model
{
    use HasFactory, SoftDeletes, BelongsToFirma;

    protected $fillable = [
        'firma_id',
        'kod',
        'ad',
        'doviz_tip',
        'acilis_bakiye',
        'is_active',
        'aciklama',
    ];

    protected $casts = [
        'acilis_bakiye' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function hareketler()
    {
        return $this->hasMany(KasaHareket::class);
    }
}
