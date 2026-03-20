<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KalenderProker extends Model
{
    use HasFactory;

    protected $fillable = [
        'kegiatan_id',
        'divisi_id',
        'tgl_mulai',
        'tgl_selesai',
        'warna',
        'is_publik',
    ];

    protected $casts = [
        'tgl_mulai' => 'date',
        'tgl_selesai' => 'date',
        'is_publik' => 'boolean',
    ];

    // Relasi ke tabel kegiatan — ambil detail kegiatan
    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    // Relasi ke tabel divisi — untuk filter per divisi
    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }
}