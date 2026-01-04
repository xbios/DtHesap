<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasFirmaScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CekHareket extends Model
{
    use HasFactory, SoftDeletes, HasFirmaScope;

    protected $table = 'cek_hareketler';

    protected $fillable = [
        'firma_id',
        'cek_id',
        'tarih',
        'islem_tip',
        'aciklama',
    ];

    protected $casts = [
        'tarih' => 'date',
    ];

    // İlişkiler
    public function firma(): BelongsTo
    {
        return $this->belongsTo(Firma::class);
    }

    public function cek(): BelongsTo
    {
        return $this->belongsTo(Cek::class);
    }

    // Scopes
    public function scopeByIslemTip($query, string $tip)
    {
        return $query->where('islem_tip', $tip);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('tarih', [$startDate, $endDate]);
    }
}
