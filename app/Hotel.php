<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Kamer;

class Hotel extends Model
{
    protected $fillable = [
        'begindatum', 'einddatum', 'kamer_id', 'service_id',
        'status', 'bedrag'
    ];
    
    use Serviceable;
    
}
