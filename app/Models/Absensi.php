<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kegiatan_id',
        'rapat_id',
        'jenis',
        'status',
        'keterangan',
        'tgl_absen',
        'validator_id',

        // ✅ FIELD CHECK-IN (FIX)
        'checkin_latitude',
        'checkin_longitude',
        'checkin_at',
    ];

    protected $casts = [
        'tgl_absen' => 'datetime',

        // ✅ penting untuk Carbon
        'checkin_at' => 'datetime',

        // ✅ optional (biar konsisten)
        'checkin_latitude' => 'float',
        'checkin_longitude' => 'float',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    public function rapat()
    {
        return $this->belongsTo(Rapat::class);
    }

    public function validator()
    {
        return $this->belongsTo(
            User::class,
            'validator_id'
        );
    }
}