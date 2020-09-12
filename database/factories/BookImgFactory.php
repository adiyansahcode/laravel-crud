<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\BookImg;
use Faker\Generator as Faker;

$factory->define(BookImg::class, function (Faker $faker) {
    return [
        'name' => $faker->image('public/storage/images',640,480, null, false),
        'description' => $faker->text,
    ];
});
