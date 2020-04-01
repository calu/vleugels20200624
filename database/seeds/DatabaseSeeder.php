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
        
        DB::table('algemeens')->insert([
            'iban' => 'BE77 4761 2457 2142',
            'bic' => 'BRUBEBB',
            'banknaam' => 'ING',
            'factuur_afzendernaam' => 'De vleugels vzw',
            'factuur_afzenderstraatennummer' => 'stokstraat, 1',
            'factuur_afzenderZipenGemeente' => '8650 Klerken',
            'factuur_afzenderTelefoon' => '051 50 12 12',
            'factuur_afzenderEmail' => 'info@devleugels.be',
            'sysadmin_email' => 'johan.calu@gmail.com'
        ]);
        
        factory( App\Contactpersoon::class,30)->create();   
        
        $this->call([
           MutTableSeeder::class, 
        ]);
        
         $this->call([
           CodeTableSeeder::class, 
        ]);     
        
        $this->call([
            KamerTableSeeder::class,
        ]);  
    }
}
