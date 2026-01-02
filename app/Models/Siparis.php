<?php

namespace App\Models;

use App\Traits\BelongsToFirma;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siparis extends Model
{
    use HasFactory, SoftDeletes, BelongsToFirma;

    protected $table = 'siparisler';

    protected $fillable = [
        'firma_id',
        'cari_id',
        'siparis_no',
        'siparis_tip',
        'tarih',
        'teslim_tarih',
        'durum',
        'toplam_tutar',
        'kdv_tutar',
        'genel_toplam',
        'doviz_tip',
        'doviz_kur',
        'aciklama',
        'created_by',
    ];

    protected $casts = [
        'tarih' => 'date',
        'teslim_tarih' => 'date',
        'toplam_tutar' => 'decimal:2',
        'kdv_tutar' => 'decimal:2',
        'genel_toplam' => 'decimal:2',
        'doviz_kur' => 'decimal:4',
    ];

    public function cari()
    {
        return $this->belongsTo(Cari::class);
    }

    public function detaylar()
    {
        return $this->hasMany(SiparisDetay::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
