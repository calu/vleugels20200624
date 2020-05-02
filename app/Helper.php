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
     * gebruikt bij Boekhouding - aangevraagde diensten 
     */
     public static function getServiceOmschrijving( $serviceable_id, $serviceable_type)
     {
         switch ($serviceable_type)
         {
             case 'App\Hotel':
               $hotel = DB::table('hotels')->find($serviceable_id);
               $omschrijving = "verblijf van ".$hotel->begindatum." tot ".$hotel->einddatum;
//               dd($hotel);
               return $omschrijving;
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
          try{
            $id = $user = Auth::user()->id;
          } catch (Exception $e)
          {
               dd("[Helper::getClient] sorry, maar dit werkt niet");
          }
          
          if ($id == null){
               dd("Gelieve je af te melden en opnieuw aan te melden");
          }
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
     
     /** 
      * We halen het klant record, vertrekkend van een serviceable(id,type);
      *
      * @param :
      *    serviceable_id
      *    serviceable_type
      *
      * @return : $client
      *
      */
     public static function getClientFromServiceable($id,$type)
     {        
           if (preg_match('/\bApp\b/', $type))
             $servicetype = $type;
           else
             $servicetype = \App\Enums\ServiceType::getValue($type);
           try{
             $service = DB::table('serviceables')
                     ->where([
                       ['serviceable_id', $id],
                       ['serviceable_type', $servicetype]
                     ])->first();
           } catch (Exception $e){
              dd("[BoekhoudingController@getClientFromServiceable] - geen overeenkomstige dienst ($id,$type)");
           }
          //  dd("[Helper::getClientFromServiceable] 1service = [id=$id en type= $type en servicetype = $servicetype ".$service);
          return Client::where('id', $service->client_id)->first();          
     }
     
     
}
