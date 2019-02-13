<?php

namespace RevoSystems\iOSPassKit\Traits;

use Illuminate\Notifications\Notifiable;
use RevoSystems\iOSPassKit\Models\PassKitDevice;
use RevoSystems\iOSPassKit\Notifications\PassKitUpdatedNotification;
use RevoSystems\iOSPassKit\Services\PassKitGenerator;

trait PassKitTrait
{
    use Notifiable;

    /**
     * Finds the walletable instance by its serial number
     */
    abstract public function findBySerialNumber($serialNumber);

    /*
     * Returns pass/giftCard/voucher identifier
     */
    abstract public function getSerialNumber();

    /*
     * Returns pass/giftCard/voucher balance field
     */
    abstract public function getBalanceField();

    public function devices()
    {
        return $this->morphToMany(PassKitDevice::class, 'pass_kit_registration');
    }

    public static function boot()
    {
        parent::boot();
        static::created(function ($pass) {
            $usernameField = config('passKit.username_field', 'username');
            $path = PassKitGenerator::make($pass)->generate(auth()->user()->$usernameField);
            // SEND MAIL
        });
        static::updating(function ($pass) {
            $usernameField = config('passKit.username_field', 'username');
            $balanceField = $pass->getBalanceField();
            if ($pass->$balanceField != $pass->getOriginal()[$balanceField]) {
                $path = PassKitGenerator::make($pass)->update(auth()->user()->$usernameField);
                $pass->notify(new PassKitUpdatedNotification(auth()->user()->$usernameField, static::class, $pass->getSerialNumber()));
            }
        });
    }

    public static function getPassKitApiToken()
    {
        return config('passKit.apiToken');
    }

    public function routeNotificationForApn()
    {
        return $this->devices()->pluck('uuid')->toArray();
    }

    public static function findRegistration($serialNumber, $passType)
    {
        return (self::getPassKitClass($passType))::where('uuid', $serialNumber)->firstOrFail();
    }

    public static function registerApn($deviceLibraryIdentifier, $passType, $serialNumber, $apnToken)
    {
        static::findRegistration($serialNumber, $passType)->devices()->attach(PassKitDevice::firstOrCreate([
            'device_library_identifier'        => $deviceLibraryIdentifier,
            config('passKit.apn_token_field')  => $apnToken
        ]));
    }

    public static function unRegisterApn($deviceLibraryIdentifier, $passType, $serialNumber)
    {
        static::findRegistration($serialNumber, $passType)->devices()->detach(
            PassKitDevice::where('device_library_identifier', $deviceLibraryIdentifier)->firstOrFail()
        );
    }

    public static function relationName()
    {
        return lcfirst(str_plural(class_basename(static::class)));
    }

    public static function getPassKitClass($passType)
    {
        return config("passKit.passTypes")[$passType];
    }

    public static function getPassTypeTable($passType)
    {
        return self::getPassKitClass($passType)::getTableName();
    }
}
