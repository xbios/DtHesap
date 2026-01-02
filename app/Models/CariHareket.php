<?php

namespace App\Models;

use App\Traits\BelongsToFirma;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CariHareket extends Model
{
    use HasFactory, SoftDeletes, BelongsToFirma;

    protected $table = 'cari_hareketler';

    protected $fillable = [
        'firma_id',
        'cari_id',
        'evrak_tip',
        'evrak_id',
        'tarih',
        'aciklama',
        'borc',
        'alacak',
        'bakiye',
        'doviz_tip',
        'doviz_kur',
    ];

    protected $casts = [
        'tarih' => 'date',
        'borc' => 'decimal:2',
        'alacak' => 'decimal:2',
        'bakiye' => 'decimal:2',
        'doviz_kur' => 'decimal:4',
    ];

    public function cari()
    {
        return $this->belongsTo(Cari::class);
    }

    public function evrak()
    {
        return $this->morphTo();
    }
}
