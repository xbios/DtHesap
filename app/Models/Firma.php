<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Firma extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kod',
        'unvan',
        'vergi_dairesi',
        'vergi_no',
        'adres',
        'il',
        'ilce',
        'telefon',
        'email',
        'website',
        'logo_path',
        'is_active',
        'ayarlar',
    ];

    protected $casts = [
        'ayarlar' => 'json',
        'is_active' => 'boolean',
    ];

    /**
     * The users that belong to the firma.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'firma_user')
            ->withPivot(['rol', 'yetki_seviyesi'])
            ->withTimestamps();
    }

    public function caris()
    {
        return $this->hasMany(Cari::class);
    }

    public function stoks()
    {
        return $this->hasMany(Stok::class);
    }

    public function faturas()
    {
        return $this->hasMany(Fatura::class);
    }

    public function kasas()
    {
        return $this->hasMany(Kasa::class);
    }

    public function bankas()
    {
        return $this->hasMany(Banka::class);
    }

    public function ceks()
    {
        return $this->hasMany(Cek::class);
    }

    public function siparisler()
    {
        return $this->hasMany(Siparis::class);
    }
}
