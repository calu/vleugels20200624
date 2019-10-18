<?php
	
namespace App;

trait Serviceable
{
    protected $fillable = ['client_id','serviceable_id','serviceable_type'];
    
    public function service($client)
    {
        return $this->services()->attach($client);
    }
    
    public function services()
    {
        return $this->morphToMany(Client::class, 'serviceable')->withTimestamps();
    }	
}