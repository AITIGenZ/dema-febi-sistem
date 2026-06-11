<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Kas extends Model
{
    use HasFactory;

    protected $table = 'kas';

    protected $fillable = [
        'jenis',
        'nominal',
        'keterangan',
        'tanggal',
        'created_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'nominal' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function ($kas) {
            if (Auth::check()) {
                $kas->created_by = Auth::id();
            }
        });
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}