<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;

class Transfer extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'crew_id',
        'transfer_date',
        'transfer_type',
        'vessel_name_before_transferring',
        'vessel_name_after_transferring',
        'previous_title',
        'new_title',
        'transfer_document',
    ];

    public function crew()
    {
        return $this->belongsTo(Crew::class);
    }

    public function getTransferDocumentUrlAttribute()
    {
        return Storage::url($this->transfer_document);
    }

    public function getVesselNameBeforeTransfer()
    {
        return $this->belongsTo(Vessel::class, 'vessel_name_before_transferring');
    }

    public function getVesselNameAfterTransfer()
    {
        return $this->belongsTo(Vessel::class, 'vessel_name_after_transferring');
    }
}
