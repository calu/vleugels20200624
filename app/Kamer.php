<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kamer extends Model
{
    protected $fillable = [
       'aantal_bedden', 'soort', 'kamernummer',  'beschrijving', 'foto'
    ];    
}
