<?php
	
namespace App;

trait Serviceable
{
    public function service($client)
    {
        return $this->services()->attach($client);
    }
    
    public function services()
    {
        return $this->morphToMany(Client::class, 'serviceable')->withTimestamps();
    }	
}