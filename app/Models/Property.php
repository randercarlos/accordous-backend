<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use SoftDeletes;

    const RECORDS_PER_PAGE = 10;
    protected $table = 'properties';
    protected $fillable = ['owner_email', 'address', 'number', 'complement', 'neighborhood', 'city', 'state'];
    protected $appends = ['status'];

    public function getStatusAttribute($value) {
        return self::contract()->exists();
    }

    public function contract()
    {
        return $this->hasOne(Contract::class);
    }
}
