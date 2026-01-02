<?php

namespace App\Models;

use App\Traits\BelongsToFirma;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StokKategori extends Model
{
    use HasFactory, SoftDeletes, BelongsToFirma;

    protected $table = 'stok_kategoriler';

    protected $fillable = [
        'firma_id',
        'parent_id',
        'ad',
        'kod',
        'sira',
    ];

    public function parent()
    {
        return $this->belongsTo(StokKategori::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(StokKategori::class, 'parent_id');
    }

    public function stoks()
    {
        return $this->hasMany(Stok::class, 'kategori_id');
    }
}
