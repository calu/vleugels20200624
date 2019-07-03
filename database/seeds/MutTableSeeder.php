<?php

use Illuminate\Database\Seeder;

class MutTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mutualiteits')->insert([
            'naam' => 'Christelijke Mutualiteiten',
        ]);
        
        DB::table('mutualiteits')->insert([
            'naam' => 'Bond Moyson',
        ]);        
    }
}
