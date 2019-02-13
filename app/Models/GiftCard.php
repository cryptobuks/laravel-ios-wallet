<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use RevoSystems\iOSPassKit\Traits\PassKitTrait;

class GiftCard extends Model
{
    use SoftDeletes;
    use PassKitTrait;

    public function findBySerialNumber($serialNumber)
    {
        return GiftCard::where('uuid', '=', $serialNumber)->first();
    }

    public function getSerialNumber()
    {
        return $this->uuid;
    }

    public function getBalanceField()
    {
        return 'balance';
    }
}
