<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Absensi;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'nim',
        'email',
        'phone',
        'photo',
        'divisi_id',
        'status',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Hanya user aktif yang bisa akses panel Filament
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->status === 'aktif';
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

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }

     public function inAppNotifications()
    {
        return $this->hasMany(UserNotification::class)
            ->orderBy('created_at', 'desc');
    }
    public function unreadNotifications()
    {
        return $this->notifications()
            ->whereNull('read_at')
            ->orderBy('created_at', 'desc');
    }
}