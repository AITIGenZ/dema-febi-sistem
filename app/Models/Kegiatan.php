<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kegiatan',
        'deskripsi',
        'tanggal',
        'lokasi',
        'kuota',
        'kategori',
        'is_publik',
        'dinas_id',
        'created_by',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'is_publik' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function ($kegiatan) {
            if (auth()->check()) {
                $kegiatan->created_by = auth()->id();
            }
        });
    }

    public function dinas()
    {
        return $this->belongsTo(Dinas::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }

    public function kalenderProker()
    {
        return $this->hasOne(KalenderProker::class);
    }

    public function dokumens()
    {
        return $this->hasMany(Dokumen::class);
    }
}