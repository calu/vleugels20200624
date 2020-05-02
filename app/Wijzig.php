<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wijzig extends Model
{
     protected $fillable=[
         'serviceable_id', 'serviceable_type', 'rubriek',
         'datumvan', 'datumtot','wijzigstatus'
     ];
}
