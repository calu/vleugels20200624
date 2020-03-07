<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vraag extends Model
{
    protected $fillable = 
       ['vraagsteller', 'vraagtype','vraag', 'status', 'datumvraag',
        'datumantwoord','antwoord'];
}
