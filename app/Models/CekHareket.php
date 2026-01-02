<?php

namespace App\Models;

use App\Traits\BelongsToFirma;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CekHareket extends Model
{
    use HasFactory, SoftDeletes, BelongsToFirma;

    protected $table = 'cek_hareketler';

    protected $fillable = [
        'firma_id',
        'cek_id',
        'tarih',
        'islem_tip',
        'aciklama',
        'created_by',
    ];

    protected $casts = [
        'tarih' => 'date',
    ];

    public function cek()
    {
        return $this->belongsTo(Cek::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
