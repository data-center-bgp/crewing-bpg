<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function vessels()
    {
        return $this->hasMany(Vessel::class);
    }

    public function crew()
    {
        return $this->hasOne(Crew::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function mcus()
    {
        return $this->hasMany(Mcu::class);
    }

    public function paidLeaves()
    {
        return $this->hasMany(PaidLeave::class);
    }

    public function resigns()
    {
        return $this->hasMany(Resign::class);
    }

    public function transfers()
    {
        return $this->hasMany(Transfer::class);
    }
}
