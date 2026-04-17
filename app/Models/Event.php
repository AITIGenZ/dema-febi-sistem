<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Event.php
class Event extends Model
{
    protected $fillable = [
        'title',
        'description',        // TAMBAHAN: Deskripsi lengkap
        'start',
        'end',
        'location',           // TAMBAHAN: Lokasi event
        'type',              // TAMBAHAN: meeting, deadline, reminder
        'status',            // TAMBAHAN: scheduled, cancelled, completed
        'user_id',           // TAMBAHAN: Relasi ke user
        'reminder_minutes',  // TAMBAHAN: Pengingat sebelum event
        'recurrence_rule',   // TAMBAHAN: Untuk event berulang
        'color',             // TAMBAHAN: Warna custom per event
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
        'is_all_day' => 'boolean',
        'metadata' => 'array', // TAMBAHAN: Data tambahan fleksibel
    ];

    // TAMBAHAN: Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // TAMBAHAN: Relasi untuk participant/attendees
    public function attendees()
    {
        return $this->belongsToMany(User::class, 'event_attendees')
                    ->withPivot('status', 'notified_at')
                    ->withTimestamps();
    }
}