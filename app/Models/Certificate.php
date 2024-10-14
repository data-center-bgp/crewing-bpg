<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;

class Certificate extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'crew_id',
        'certificate_type',
        'certificate_number',
        'issue_date',
        'expiry_date',
        'certificate_status',
    ];

    public function crew()
    {
        return $this->belongsTo(Crew::class);
    }

    public function getCertificateDocumentUrlAttribute()
    {
        return Storage::url($this->certificate_document);
    }
}
