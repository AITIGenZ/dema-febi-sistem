<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Rapat extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal',
        'lokasi',
        'tipe',
        'divisi_id',
        'created_by',
        'status_pengajuan',
        'approved_by',
        'approved_at',

        // ✅ FIELD GPS (FIX)
        'latitude',
        'longitude',
        'radius',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'approved_at' => 'datetime',

        // ✅ Optional tapi bagus untuk akurasi
        'latitude' => 'float',
        'longitude' => 'float',
        'radius' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function ($rapat) {

            if (Auth::check()) {
                $rapat->created_by = Auth::id();
            }

            if (empty($rapat->status_pengajuan)) {
                $rapat->status_pengajuan = 'pending';
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isPending(): bool
    {
        return $this->status_pengajuan === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status_pengajuan === 'disetujui';
    }

    public function isRejected(): bool
    {
        return $this->status_pengajuan === 'ditolak';
    }
}