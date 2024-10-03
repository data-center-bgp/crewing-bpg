<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Mcu extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'crew_id',
        'mcu_document',
        'issue_date',
        'expiry_date',
        'certificate_status',
    ];

    public function crew()
    {
        return $this->belongsTo(Crew::class);
    }
}
