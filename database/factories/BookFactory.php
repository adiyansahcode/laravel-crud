<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'isbn' => $faker->isbn13,
        'title' => $faker->word,
        'publication_date' => $faker->date('Y-m-d', 'now'),
        'weight' => $faker->randomDigitNotNull,
        'wide' => $faker->randomDigitNotNull,
        'long' => $faker->randomDigitNotNull,
        'page' => $faker->randomDigitNotNull,
        'page' => $faker->randomDigitNotNull,
        'description' => $faker->text,
    ];
});
