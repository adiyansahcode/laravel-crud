<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Publisher;
use Faker\Generator as Faker;

$factory->define(Publisher::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'description' => $faker->text,
        'city' => $faker->city,
    ];
});
