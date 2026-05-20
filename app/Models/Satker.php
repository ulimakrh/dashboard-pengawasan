<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Satker extends Model
{
    protected $fillable = [
        'nama_entitas',
        'tipe_entitas',
        'lokasi',
        'wilayah_id',
        'jumlah_hs',
        'jumlah_ls',
        'is_active'
    ];

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class);
    }
}