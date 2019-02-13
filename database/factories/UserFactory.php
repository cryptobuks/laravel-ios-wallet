<?php

use App\Business;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => Str::random(10),
    ];
});

$factory->define(Business::class, function (Faker $faker) {
    return [
        "passes" => json_encode([
                "giftCards" => [
                    "serialNumber" => "1234",
                    "locations" => [
                        [
                            "latitude" => 41.673385,
                            "longitude" => 1.764578,
                            "relevantText" => "Benet home is near you."
                        ]
                    ],
                    "barcode" => [
                        "message" => "1234",
                        "format" => "PKBarcodeFormatQR",
                        "messageEncoding" => "iso-8859-1"
                    ],
                    "organizationName" => "REVO",
                    "description" => "Gift Card",
                    "logoText" => "Gift Card",
                    "backgroundColor" => "#3B312F",
                    "foregroundColor" => "#F2653A",
                    "labelColor" => "#F2653A",
                    "storeCard" => [
                        "primaryFields" => [
                            [
                                "label" => "Saldo"
                            ]
                        ],
                        "backFields" => [
                            [
                                "key" => "giftcard-code",
                                "label" => "Gift Card",
                                "value" => "1234"
                            ],[
                                "key" => "website",
                                "label" => "Check our website",
                                "value" => "http =>//www.example.com/track-bags/XYZ123"
                            ]
                        ]
                    ]
                ]
            ]
        )
    ];
});

