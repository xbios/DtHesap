<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use Traits\HasFirmaScope;

    protected $fillable = [
        'firma_id',
        'user_id',
        'log_level',
        'category',
        'action',
        'message',
        'details',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'details' => 'array',
    ];

    // İlişkiler
    public function firma()
    {
        return $this->belongsTo(Firma::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper method to log events
    public static function log(string $category, string $action, string $message, array $details = [], string $level = 'info')
    {
        return self::create([
            'category' => $category,
            'action' => $action,
            'message' => $message,
            'details' => $details,
            'log_level' => $level,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'user_id' => auth()->id(),
        ]);
    }
}
