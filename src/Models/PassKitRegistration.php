<?php

namespace RevoSystems\iOSPassKit\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PassKitRegistration extends Model
{
    protected $guarded = [];
    use SoftDeletes;

    public function devices()
    {
        return $this->hasMany(PassKitDevice::class);
    }

//    public function passes()
//    {
//        return $this->hasMany(PassKitTrait::class);
//    }
}