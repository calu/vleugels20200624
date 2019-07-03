<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('users')->insert([
            'name' => 'administrator',
            'email' => 'admin@vleugels.be',
            'password' => bcrypt('vleugels'),
            'admin' => 1
        ]);     
        
        factory( App\Contactpersoon::class,30)->create();   
        
        $this->call([
           MutTableSeeder::class, 
        ]);
        
         $this->call([
           CodeTableSeeder::class, 
        ]);       
    }
}
