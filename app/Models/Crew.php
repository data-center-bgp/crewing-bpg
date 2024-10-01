<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Crew extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'user_id',
        'vessel_id',
        'name',
        'nik',
        'birthplace',
        'birthdate',
        'phone_number',
        'address',
        'npwp',
        'bank_name',
        'bank_number',
        'bank_account_name',
        'marital_status',
        'title',
        'sign_on',
        'degree',
        'graduation_year',
        'seafarer_book_number',
        'seafarer_code',
        'monsterol_issue_date',
        'monsterol_expiry_date',
        'crew_status',
    ];

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
