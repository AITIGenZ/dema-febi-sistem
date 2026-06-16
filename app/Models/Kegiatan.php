<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
        'status_pengajuan',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'approved_at' => 'datetime',
        'is_publik' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function ($kegiatan) {
            if (Auth::check()) {
                $kegiatan->created_by = Auth::id();
            }
            if (empty($kegiatan->status_pengajuan)) {
                $kegiatan->status_pengajuan = 'pending';
            }
        });
    }

    public function dinas()
    {
        return $this->belongsTo(Dinas::class, 'dinas_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
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

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}