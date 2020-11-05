<?php

use App\Models\Property;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use \Illuminate\Support\Arr;

$factory->define(Property::class, function (Faker $faker) {
    return [
        'owner_email' => $faker->email,
        'address' => $faker->streetName,
        'number' => random_int(1, 1000),
        'complement' => $faker->secondaryAddress,
        'neighborhood' => $faker->citySuffix,
        'city' => $faker->city,
        'state' => Arr::random([
            'AL',
            'AC',
			'AP',
			'AM',
			'BA',
			'CE',
			'DF',
			'ES',
			'GO',
			'MA',
			'MT',
			'MS',
			'MG',
			'PA',
			'PB',
			'PR',
			'PE',
			'PI',
			'RJ',
			'RN',
			'RS',
			'RO',
			'RR',
			'SC',
			'SP',
			'SE',
			'TO'
        ]),
    ];
});
