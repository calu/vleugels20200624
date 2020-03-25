<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
      'voornaam', 'familienaam', 'straat', 'huisnummer', 'bus',
      'postcode', 'gemeente', 'telefoon', 'gsm', 'email',
      'wachtwoord', 'geboortedatum', 'rrn', 'mutualiteit_id',
      'factuur_naam', 'factuur_straat','factuur_huisnummer', 
      'factuur_bus', 'factuur_postcode', 'factuur_gemeente',
      'factuur_email', 'statuut', 'contactpersoon_id',
      'user_id',
    ];
    
    public function contactpersoon()
    {
          return $this->belongsTo('\App\Contactpersoon');
    }
    
    public function is_bij_mutualiteit()
    {
          return $this->hasOne('\App\Mutualiteit');
    }
    
    public function services()
    {
          return $this->belongsToMany(Service::class);
    }
    

}
