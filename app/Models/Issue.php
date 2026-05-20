<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Issue extends Model
{
    protected $fillable = [
        'satker_id', 
        'kategori', 
        'deskripsi_isu', 
        'tindak_lanjut', 
        'status', 
        'update_oleh'
    ];

    public function satker(): BelongsTo
    {
        return $this->belongsTo(Satker::class);
    }
}