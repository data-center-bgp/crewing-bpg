<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Crew extends Model
{
    use HasFactory, HasRoles;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vessel()
    {
        return $this->belongsTo(Vessel::class);
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
