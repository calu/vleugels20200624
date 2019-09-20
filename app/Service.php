<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
   protected $fillable = [
       'reservatiesoort', 'status', 'user_id'
   ];
   
   public function clients()
   {  
      return $this->belongsToMany(Client::class)->withPivot('client_id');
   }
   
   public function hotel()
   {
      return $this->hasOne(Hotel::class);
   }
}
