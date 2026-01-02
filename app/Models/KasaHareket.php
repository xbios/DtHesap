<?php

namespace App\Models;

use App\Traits\BelongsToFirma;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KasaHareket extends Model
{
    use HasFactory, SoftDeletes, BelongsToFirma;

    protected $table = 'kasa_hareketler';

    protected $fillable = [
        'firma_id',
        'kasa_id',
        'evrak_tip',
        'evrak_id',
        'tarih',
        'islem_tip',
        'tutar',
        'doviz_tip',
        'doviz_kur',
        'aciklama',
    ];

    protected $casts = [
        'tarih' => 'date',
        'tutar' => 'decimal:2',
        'doviz_kur' => 'decimal:4',
    ];

    public function kasa()
    {
        return $this->belongsTo(Kasa::class);
    }

    public function evrak()
    {
        return $this->morphTo();
    }
}
