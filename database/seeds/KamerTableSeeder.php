<?php

use Illuminate\Database\Seeder;

class KamerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kamers')->insert([
           'kamernummer' => 101,
           'aantal_bedden' => 1,
           'soort' => 1,
           'beschrijving' => 'Deze luxueuse kamer is er voor jou alleen. Je kan er genieten van een prachtig zicht op de omliggende weiden',
           'foto' => 'kamer101.jpg'
        ]);

        DB::table('kamers')->insert([
           'kamernummer' => 102,
           'aantal_bedden' => 3,
           'soort' => 2,
           'beschrijving' => 'In deze kamer kan je samen met je kamergenoot genieten van alle rust',
           'foto' => 'kamer102.jpg'
        ]);

        DB::table('kamers')->insert([
           'kamernummer' => 201,
           'aantal_bedden' => 2,
           'soort' => 2,
           'beschrijving' => 'Samen met je kamergenoot kan je heel activiteiten uitvoeren',
           'foto' => 'kamer201.jpg'
        ]);

        DB::table('kamers')->insert([
           'kamernummer' => 202,
           'aantal_bedden' => 2,
           'soort' => 3,
           'beschrijving' => 'Geniet van je dag',
           'foto' => 'kamer202.jpg'
        ]);

    }
}
