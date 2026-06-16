<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipe',
        'nama',
        'nominal',
        'berlaku_mulai',
        'berlaku_sampai',
        'is_active',
    ];

    protected $casts = [
        'nominal'       => 'decimal:2',
        'berlaku_mulai' => 'date',
        'berlaku_sampai'=> 'date',
        'is_active'     => 'boolean',
    ];

    public function pembayaranKas()
    {
        return $this->hasMany(PembayaranKas::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeBulanan($query)
    {
        return $query->where('tipe', 'bulanan');
    }

    public function scopeTemporal($query)
    {
        return $query->where('tipe', 'temporal');
    }
}