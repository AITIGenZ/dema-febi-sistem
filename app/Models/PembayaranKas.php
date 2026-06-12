<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PembayaranKas extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_kas';

    protected $fillable = [
        'user_id',
        'kas_setting_id',
        'kas_id',
        'bulan',
        'tahun',
        'nominal',
        'status',
        'tgl_bayar',
        'created_by',
    ];
    

    protected $casts = [
        'nominal_bayar' => 'decimal:2',
        'tanggal_bayar' => 'date',
    ];

    protected static function booted(): void
    {
        static::creating(function ($pembayaran) {
            if (Auth::check()) {
                $pembayaran->created_by = Auth::id();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kasSetting()
    {
        return $this->belongsTo(KasSetting::class);
    }

    public function kas()
    {
        return $this->belongsTo(Kas::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}