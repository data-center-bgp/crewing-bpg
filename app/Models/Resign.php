<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Resign extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'crew_id',
        'resign_date',
        'remark',
    ];

    public function crew()
    {
        return $this->belongsTo(Crew::class);
    }
    
}
