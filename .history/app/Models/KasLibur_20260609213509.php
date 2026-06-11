<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasLibur extends Model
{
    use HasFactory;

    protected $fillable = [
        'bulan',
        'tahun',
        'keterangan',
    ];

    public function isLibur(int $bulan, int $tahun): bool
    {
        return static::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->exists();
    }
}