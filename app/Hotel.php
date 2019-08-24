<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'begindatum', 'einddatum', 'kamer_id', 'service_id'
    ];
    
    public function service()
    {
        return $this->hasOne(Service::class);
    }
}
