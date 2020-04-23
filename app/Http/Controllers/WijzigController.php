<?php

namespace App\Http\Controllers;

use App\Wijzig;
use Illuminate\Http\Request;
use App\Hotel;
use App\Client;
use App\Contactpersoon;
use App\Helper;
use Validator;
use App\Factuur;
use Illuminate\Support\Facades\Mail;
use App\Mail\WijzigConfirmatieMail;
use Illuminate\Support\Facades\DB;

class WijzigController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }
        
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
       $thisRequest = request()->all();
       $data = $thisRequest['data'];
      
       session(['data', $data]);

      // valideer
         $validator = Validator::make( $data, [
          'serviceable_id' => 'required | integer',
          'serviceable_type' => 'required',
          'rubriek' => 'required',
          'datumvan' => 'required | date | after:tomorrow',
          'datumtot' => 'required | date | after:datumvan',
          'wijzigstatus' => 'required',
        ])->validate();        
      
      // spaar in tabel wijzigs
      $wijzig['serviceable_id'] = $data['serviceable_id'];
      $wijzig['serviceable_type'] = $data['serviceable_type'];
      $wijzig['rubriek'] = $data['rubriek'];
      $wijzig['datumvan'] = $data['datumvan'];
      $wijzig['datumtot'] = $data['datumtot'];
      $wijzig['wijzigstatus'] = $data['wijzigstatus'];
      $wijzigs = Wijzig::create($wijzig);
      
      // voor de diensten / vb. in hotels op 'goedgekeurd' en data aanpassen (als aanvaard) / of verwijderen als 
      // factuur proforma is en annulatie - als factuur reeds verstuurd dan nieuwe factuur met
      // negatief bedrag
      if ($data['wijzigstatus'] != 'geweigerd'){
        $ret = $this->wijzigdienst($wijzig);
        $bericht = $ret['bericht'];
      }
      else
         $bericht = "Er werd niets gedaan, vermits de aanvraag geweigerd werd";
      // stuur e-mail naar admin (met eventueel factuur als bijlage)
      $client = Helper::getClientFromServiceable($data['serviceable_id'],$data['serviceable_type']);
      $info['klantnaam'] = $client->voornaam.' '.$client->familienaam;      
      $cp = Contactpersoon::where('id', $client->contactpersoon_id)->get()->first();  
      $info['contactpersoon'] = $cp->voornaam.' '.$cp->familienaam;
      $info['diensttype'] = $data['serviceable_type'];
      $info['begindatum'] =  $data['datumvan'];
      $info['einddatum'] =  $data['datumtot'];
      if ($data['wijzigstatus'] == 'geweigerd' || $ret['nieuweFactuur'] == null)
        $url = "boekhouding/".$data['serviceable_id']."/".$data['serviceable_type']."/detail";
      else
        $url = "boekhouding/".$ret['nieuweFactuur']->serviceable_id."/".$ret['nieuweFactuur']->serviceable_type."/detail";
      $info['urlfactuur'] = url($url); 
      
      // pas ook de data aan in hotel
      
      
      Mail::to('info@devleugels.be')->send(new WijzigConfirmatieMail($info));
           
      // bericht - naargelang bovenstaande info
      session()->flash('bericht', $bericht);
//      session(['info' => $info]);
//      session(['servicetype' => $wijzig['serviceable_type']]);
      
//      $url = 'test';
      $url = 'wijzig/'.$data['serviceable_id'].'/'.$wijzig['serviceable_type'];
      return ['message' => $url];       
    }
    
    /**
     *  naargelang de dienst plaatsen we de status op goedgekeurd en passen de data aan
     *  maar ook :
     *  als de factuur PRO FORMA is en rubriek == annulatie--> verwijder de factuur
     *  anders : een nieuwe proforma factuur opstellen en deze versturen
     */
    public function wijzigdienst($wijzig)
    {
      switch( $wijzig['serviceable_type']){
        case 'hotel' :
          $hotel = Hotel::findOrFail($wijzig['serviceable_id']);
          $hotel->status = 'goedgekeurd';
          $hotel->begindatum = $wijzig['datumvan'];
          $hotel->einddatum = $wijzig['datumtot'];
          $hotel->save();
          break;
        case 'dagverblijf' :
          // TODO 
          break;
        case 'therapie' :
          // TODO
          break;
      }
      
      // zoek nu de factuur die hoort bij deze aanvraag
      $nieuweFactuur = null;
      $serviceid = $wijzig['serviceable_id'];
      $servicetype = \App\Enums\ServiceType::getValue($wijzig['serviceable_type']);
      $factuur = \App\Factuur::where([
            [ 'serviceable_id' , $serviceid],
            [ 'serviceable_type', $servicetype ]
        ])->orderBy('datum', 'desc')->first();
        
       session(['factuur' => $factuur]);   
       if ( $factuur->factuurvolgnummer == null){
         // Het is een pro forma factuur
         // Als de rubriek annulatie is --> verwijder de factuur
         if ($wijzig['rubriek'] == 'annulatie'){
           // verwijder de factuur
//           $factuur->delete();
           // schrap de reservatie 
            switch( $wijzig['serviceable_type']){
              case 'hotel' :
                
                // verwijder de entry in serviceable
/*                $serviceable = DB::table('serviceables')->where([
            [ 'serviceable_id' , $serviceid],
            [ 'serviceable_type', $servicetype ]])->delete();
                $hotel->delete();
 */
                break;
              case 'dagverblijf' :
                // TODO 
                break;
              case 'therapie' :
                // TODO
                break;
            }          
           // bericht
           $bericht = "Onze diensten zullen je contacteren om deze aanvraag te bespreken";
           $nieuweFactuur = null;
         } else {
           // geen annulatie maar een wijziging in data
           // wijzig de data in factuur en maak een nieuwe factuur
           $nieuweFactuur = $factuur;
           $oudeFactuur_id = $factuur->id;
           
           $nieuweFactuur->datum = date('Y-m-d');
           $nieuweFactuur->jaar = date('Y');
           $nieuweFactuur->omschrijving = "van ".$wijzig['datumvan']." tot ".$wijzig['datumtot'];
           $nieuweFactuur->id = 0;
           $nieuweFactuur = $nieuweFactuur->create();
           $factuur->referentie = $nieuweFactuur->id;
           $factuur->save();
         }      
       }  else {
         // Er bestaat reeds een Factuur -- nu moet je corrigeren
         // Als het annulatie en niet geweigerd ... maak een negatieve factuur
           if ($wijzig['rubriek'] == 'annulatie'){
             // een annulatie - dus een negatieve factuur
             $temp['factuurvolgnummer'] = Helper::getFactuurnummer();
             $temp['jaar'] =  date('Y');
             $temp['datum'] = date('Y-m-d');
             $temp['serviceable_id'] = $serviceid;
             $temp['serviceable_type'] = $servicetype;
             $temp['omschrijving'] = $factuur->omschrijving;
             $temp['aantal'] = $factuur->aantal;
             $temp['prijs'] = -$factuur->prijs;
             $temp['betaald'] = $factuur->betaald;
             $temp['referentie'] = null;
             $nieuweFactuur = Factuur::create($temp);
             $factuur->referentie = $nieuweFactuur->id;
             $bericht = "Er werd een kredietnota opgesteld voor deze annulatie";
           } else {
             // een wijziging -- ook een nieuwe factuur voor het verschil??
             $temp['factuurvolgnummer'] = Helper::getFactuurnummer();
             $temp['jaar'] =  date('Y');
             $temp['datum'] = date('Y-m-d');
             $temp['serviceable_id'] = $serviceid;
             $temp['serviceable_type'] = $servicetype;
             $temp['omschrijving'] = "van ".$wijzig['datumvan']." tot ".$wijzig['datumtot'];
             $temp['aantal'] = $factuur->aantal;
             $temp['prijs'] = -$factuur->prijs;
             $temp['betaald'] = false;
             $temp['referentie'] = null;
             $nieuweFactuur = Factuur::create($temp);
             $factuur->referentie = $nieuweFactuur->id;
             $factuur->save();
             $bericht = "Er werd een factuur opgesteld voor deze wijziging / Controleer goed";
           }
       }
       $ret['bericht'] = $bericht;
       $ret['nieuweFactuur'] = $nieuweFactuur;
       if ($nieuweFactuur == null)
         $ret['nieuweFactuur_id'] = 0;
       else
         $ret['nieuweFactuur_id'] = $nieuweFactuur->id;
       return $ret;
    }

    /**
     * Display the specified resource.
     *
     * @param  $id = de service waarvoor een aanvraag volgt
     * @return \Illuminate\Http\Response
     */
    public function show($id, $type)
    {
        dd("show $id");
        
        
    }
    
    public function showService($id, $type)
    {
        // dd("showService id = $id en type = $type");
        $info['serviceable_id'] = $id;
        $info['serviceable_type'] = $type;
        
        
        $wijzig['serviceable_id'] = $id;
        $wijzig['serviceable_type'] = $type;
        // We halen de service op en maken er een afzonderlijke array van
        switch ($type){
            case 'hotel' :
              $hotelfiche = Hotel::findOrFail($id)->first();
             //  dd($hotel);
  //            $info['service'] = $hotel;
              $wijzig['datumvan'] = $hotelfiche->begindatum;
              $wijzig['datumtot'] = $hotelfiche->einddatum;
              $hotel['begindatum'] = $hotelfiche->begindatum;
              $hotel['einddatum'] = $hotelfiche->einddatum;
               
              break;
            case 'dagverblijf':
              break;
            case 'therapie':
              break;
        }
        
        // maak nu een blanko Wijzig
        $wijzig['id'] = 0;
        $wijzig['fullserviceable_type'] = \App\Enums\ServiceType::getValue($type); 
        $wijzig['rubriek'] = 'annulatie';
        $wijzig['wijzigstatus'] = 'aangevraagd';
 // de onderstaande waarden worden ingevuld in de soort dienst hierboven       
 //       $wijzig['datumvan'] = null;
 //       $wijzig['datumtot'] = null;
 //       $service['wijzig'] = $wijzig;
        
        $client = Helper::getClientFromServiceable($id,$type);
 //       $service['klantnaam'] = $client->voornaam.' '.$client->familienaam;
 
        $contactpersoon = Contactpersoon::where('id', $client->contactpersoon_id)->get()->first();
        
  //      $service['service']['contactpersoon'] = 
 //       $service['cpnaam'] = $cp->voornaam.' '.$cp->familienaam;
        $hotel['kamer_id'] = $hotelfiche->kamer_id;
        $hotel['status'] = $hotelfiche->status;
        $hotel['bedrag'] = $hotelfiche->bedrag;
        $hotel['client'] = $client;
        $hotel['contactpersoon'] = $contactpersoon;
        $info['hotel'] = $hotel;
        $info['wijzig'] = $wijzig;

        

        return view('wijzig.show', compact('info'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Wijzig  $wijzig
     * @return \Illuminate\Http\Response
     */
    public function edit(Wijzig $wijzig)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Wijzig  $wijzig
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

      $thisRequest = request()->all();
      $data = $thisRequest['data'];
      
      session(['thisRequest', $thisRequest]);
      session(['update', 'update']);
      // valideer
      
      // spaar
      
      // stuur e-mail
      
      // bericht
      
      $url = 'test';
      return ['message' => $url];   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Wijzig  $wijzig
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wijzig $wijzig)
    {
        //
    }
    
    /**
     * We tonen alle openstaande wijziging/annulatie aanvragen
     *
     * @param : geen
     * @return : Response
     */
    public function adminOverzicht(){
      // enkel de admin mag hier komen
      
      // haal alle aanvragen op
      
      // toon deze
    }
}
