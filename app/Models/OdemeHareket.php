<?php

namespace App\Models;

use App\Traits\BelongsToFirma;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OdemeHareket extends Model
{
    use HasFactory, SoftDeletes, BelongsToFirma;

    protected $table = 'odeme_hareketler';

    protected $fillable = [
        'firma_id',
        'fatura_id',
        'tarih',
        'tutar',
        'odeme_tip',
        'kasa_id',
        'banka_id',
        'cek_id',
        'aciklama',
    ];

    protected $casts = [
        'tarih' => 'date',
        'tutar' => 'decimal:2',
    ];

    public function fatura()
    {
        return $this->belongsTo(Fatura::class);
    }

    public function kasa()
    {
        return $this->belongsTo(Kasa::class);
    }

    public function banka()
    {
        return $this->belongsTo(Banka::class);
    }

    public function cek()
    {
        return $this->belongsTo(Cek::class);
    }
}
