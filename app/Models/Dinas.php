<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dinas extends Model
{
    use HasFactory;

    protected $table = 'dinas';

    protected $fillable = [
        'nama_dinas',
        'deskripsi',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'dinas_id');
    }

    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class, 'dinas_id');
    }

    public function kalenderProker()
    {
        return $this->hasMany(KalenderProker::class, 'dinas_id');
    }
}