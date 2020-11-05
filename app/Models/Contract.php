<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use SoftDeletes;

    const RECORDS_PER_PAGE = 10;
    protected $table = 'contracts';
    protected $fillable = ['contractor_fullname', 'contractor_email', 'person_type', 'document', 'property_id'];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
