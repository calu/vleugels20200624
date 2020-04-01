<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;

class Helper extends Model
{
    /**
     * Deze class gebruiken we om allerlei functies te definiëren die ons zullen
     * kunnen helpen
     *
     * function 1 : getService( $serviceable_id, $serviceable_type)
     * Naargelang het soort wordt de servicegegevens opgehaald.
     *
 WORDT NIET GEBRUIKT   
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
     
     /**
      * de function getClient
      *  Zal de id van de klant ophalen. Wat we kunnen ophalen is de id van de user
      *  en met deze id gaan zoeken, welke klant het is en dan gewoon die id terugsturen
      * Als er niemand is aangemaald retourneer dan 0 (null)
      */
     public static function getClient()
     {
          $id = $user = Auth::user()->id;
         // dd("id = ".$id);
          $client_id = DB::table('clients')->where('user_id', $id)->get()->first()->id;
          return $client_id;
     }
     
     /**
      * getFactuurnummer
      *   maakt een factuurnummer aan. Let wel het volledig
      *   factuurnummer heeft de form "jaar/volgnummer" en
      *   hier maken we enkel het volgnummer aan.
      *   Het volgnummer halen we uit
      *   de tabel factuurs - waar we het hoogste nummer
      *   halen voor de entry's van dit jaar.
      *   Als er geen zo'n nummer is ... dan geven we hier het
      *   nummer 1
      */
     public static function getFactuurnummer()
     {
          // bepaal het huidig jaar
          $jaar = date('Y');
          // Haal alle entries in factuurs waar jaar = $jaar
          // rangschik desc en neem dan de eerste
          $nummer = DB::table('factuurs')->where('jaar',$jaar)->orderByRaw('factuurvolgnummer DESC')->first();
          if ($nummer == null)
            return 1;
          else {
 //              dd($nummer);            
//             dd("Helper.php - getFactuurnummer - verder doen");
             return $nummer->factuurvolgnummer + 1;
          }
     }
     
     
}
