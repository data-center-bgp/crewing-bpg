<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Vessel extends Model
{
    use HasFactory, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'flag',
        'type',
        'name',
        'fleet',
        'contract_status',
        'hire_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function crews()
    {
        return $this->hasMany(Crew::class);
    }
}
