<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class PaidLeave extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'crew_id',
        'start_date',
        'end_date',
        'actual_start_date',
        'actual_end_date',
        'crew_replacement_name',
        'crew_replacement_nik',
        'leave_status',
    ];

    public function crew()
    {
        return $this->belongsTo(Crew::class);
    }
}
