<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Kamer;

class Hotel extends Model
{

    protected $fillable = [
        'begindatum', 'einddatum', 'kamer_id', 'service_id',
        'status', 'bedrag', 
        'client_id', 'serviceable_id','serviceable_type'
    ];
    
 //   use Serviceable;
     public function service($client)
    {
        return $this->services()->attach($client);
    }
    
    public function services()
    {
        return $this->morphToMany(Client::class, 'serviceable')->withTimestamps();
    }	
    
    public function getHotels($client)
    {
        return $this->belongsToMany(Client::class, 'client_id');
    }
    
}
