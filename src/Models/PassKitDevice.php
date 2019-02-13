<?php

namespace RevoSystems\iOSPassKit\Models;

use Illuminate\Database\Eloquent\Model;

class PassKitDevice extends Model
{
    protected $guarded  = [];

    public function getTable()
    {
        return config('passKit.devices_table', 'devices');
    }
}
