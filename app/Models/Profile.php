<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
    'satker_id',
    'kontak',

    'kepala_nama',
    'kepala_telp',

    'hoc_nama',
    'hoc_telp',

    'ppk_nama',
    'ppk_telp',

    'bpkrt_nama',
    'bpkrt_telp',
	
    'tahun_audit',
    'status_rr',
    'area_resiko',
    'temuan'
];

    public function satker()
    {
        return $this->belongsTo(Satker::class);
    }
}