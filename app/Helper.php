<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Helper extends Model
{
    /**
     * Deze class gebruiken we om allerlei functies te definiëren die ons zullen
     * kunnen helpen
     *
     * function 1 : getService( $serviceable_id, $serviceable_type)
     * Naargelang het soort wordt de servicegegevens opgehaald.
     *
     */
     public static function getService( $serviceable_id, $serviceable_type)
     {
         switch ($serviceable_type)
         {
             case 'App\Hotel':
               $service = DB::table('hotels')->find($serviceable_id);
 //              dd($service);
               return $service;
             case 'App\Dagverblijf':
               dd("[Helper@getService] dagverblijf nog te implementeren ");
               break;
             case 'App\Therapie':
               dd("[Helper@getService] therapie nog te implementeren ");
               break;
         }
     }
}
