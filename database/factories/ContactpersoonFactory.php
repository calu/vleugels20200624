<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Contactpersoon;
use Faker\Generator as Faker;

$factory->define(Contactpersoon::class, function (Faker $faker) {
    return [
        'voornaam' => $faker->firstName,
		'familienaam' => $faker->lastName,
		'relatie' => 'vader',
		'straat' => $faker->streetName,
		'huisnummer' => $faker->buildingNumber,
		'bus' => $faker->secondaryAddress,
		'postcode' => $faker->postcode,
		'gemeente' => $faker->city,
		'telefoon' => $faker->phoneNumber,
		'gsm' => $faker->phoneNumber,
        'email' => $faker->unique()->safeEmail,
        'rubriek' => 'hotel',
		'vraag' => $faker->text($maxNbChars = 50),
		'openstaand' => $faker->numberBetween($min=0, $max=1),
    ];
});
