<?php

namespace App\Models;

use App\Traits\BelongsToFirma;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankaHareket extends Model
{
    use HasFactory, SoftDeletes, BelongsToFirma;

    protected $table = 'banka_hareketler';

    protected $fillable = [
        'firma_id',
        'banka_id',
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

    public function banka()
    {
        return $this->belongsTo(Banka::class);
    }

    public function evrak()
    {
        return $this->morphTo();
    }
}
