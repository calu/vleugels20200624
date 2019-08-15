<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contactpersoon extends Model
{
    protected $fillable = [
      'voornaam', 'familienaam', 'straat',
      'huisnummer', 'bus', 'postcode', 'gemeente',
      'telefoon', 'gsm', 'email', 'rubriek', 'vraag',
      'openstaand', 'relatie'
    ];
    
    public function sluit()
    {
          $this->openstaand = 0;
    }
    
    public function client()
    {
          return $this->hasMany('\App\Client');
    }
}
