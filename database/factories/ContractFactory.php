<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Contract;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

$factory->define(Contract::class, function (Faker $faker) {
    static $i = 1;
    $person_type = Arr::random(['PF','PJ']);
    return [
        'contractor_fullname' => $faker->name,
        'contractor_email' => $faker->email,
        'person_type' => $person_type,
        // 'document' => Arr::random(['419.721.310-79', '389.410.290-07', '718.587.320-77', '08.461.348/0001-98',
        //     '34.294.857/0001-83', '95.325.165/0001-40']),
        'document' => $person_type == 'PF' ? $faker->cpf : $faker->cnpj,
        'property_id' => $i++
    ];
});
