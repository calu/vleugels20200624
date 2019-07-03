<?php

use Illuminate\Database\Seeder;

class CodeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   // RTH 
        DB::table('codes')->insert([
            'statuut' => '0',
            'activiteit' => '0',
            'prijs' => '100.00',
        ]);
        
        DB::table('codes')->insert([
            'statuut' => '0',
            'activiteit' => '1',
            'prijs' => '100.00',
        ]);     
        
        DB::table('codes')->insert([
            'statuut' => '0',
            'activiteit' => '2',
            'prijs' => '100.00',
        ]);   
        
        DB::table('codes')->insert([
            'statuut' => '0',
            'activiteit' => '3',
            'prijs' => '100.00',
        ]);  
        
        DB::table('codes')->insert([
            'statuut' => '0',
            'activiteit' => '4',
            'prijs' => '100.00',
        ]);  
        
        // MFC
        DB::table('codes')->insert([
            'statuut' => '1',
            'activiteit' => '0',
            'prijs' => '100.00',
        ]);
        
        DB::table('codes')->insert([
            'statuut' => '1',
            'activiteit' => '1',
            'prijs' => '100.00',
        ]);     
        
        DB::table('codes')->insert([
            'statuut' => '1',
            'activiteit' => '2',
            'prijs' => '100.00',
        ]);   
        
        DB::table('codes')->insert([
            'statuut' => '1',
            'activiteit' => '3',
            'prijs' => '100.00',
        ]);  
        
        DB::table('codes')->insert([
            'statuut' => '1',
            'activiteit' => '4',
            'prijs' => '100.00',
        ]);  
        
        // PVF
        DB::table('codes')->insert([
            'statuut' => '2',
            'activiteit' => '0',
            'prijs' => '100.00',
        ]);
        
        DB::table('codes')->insert([
            'statuut' => '2',
            'activiteit' => '1',
            'prijs' => '100.00',
        ]);     
        
        DB::table('codes')->insert([
            'statuut' => '2',
            'activiteit' => '2',
            'prijs' => '100.00',
        ]);   
        
        
        // PAB
        DB::table('codes')->insert([
            'statuut' => '3',
            'activiteit' => '0',
            'prijs' => '100.00',
        ]);
        
        DB::table('codes')->insert([
            'statuut' => '3',
            'activiteit' => '1',
            'prijs' => '100.00',
        ]);     
        
        DB::table('codes')->insert([
            'statuut' => '3',
            'activiteit' => '2',
            'prijs' => '100.00',
        ]);   
        
        DB::table('codes')->insert([
            'statuut' => '3',
            'activiteit' => '3',
            'prijs' => '100.00',
        ]);  
        
        DB::table('codes')->insert([
            'statuut' => '3',
            'activiteit' => '4',
            'prijs' => '100.00',
        ]);                                           
    }
}
