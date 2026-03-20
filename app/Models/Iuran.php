<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iuran extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bulan',
        'nominal',
        'status',
        'tgl_bayar',
        'bukti_bayar',
    ];

    protected $casts = [
        'tgl_bayar' => 'date',
        'nominal' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}