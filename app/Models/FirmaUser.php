<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FirmaUser extends Pivot
{
    protected $table = 'firma_user';

    protected $fillable = [
        'firma_id',
        'user_id',
        'rol',
        'yetki_seviyesi',
    ];

    protected $casts = [
        'yetki_seviyesi' => 'integer',
    ];

    // İlişkiler
    public function firma(): BelongsTo
    {
        return $this->belongsTo(Firma::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
