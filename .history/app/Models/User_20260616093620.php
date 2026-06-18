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
            'password'          => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->status === 'aktif';
    }

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

    // ✅ unreadNotifications() dihapus — sudah ada di trait Notifiable
}