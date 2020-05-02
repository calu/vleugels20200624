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
use App\Mail\AdminWijzigMail;
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
       // op vraag van klant
       
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
 // Het sparen van de wijzigdata wordt uitgesteld tot we zeker weten wat we moeten opslaan
 //     $wijzigs = Wijzig::create($wijzig);
      
      // voor de diensten / vb. in hotels op 'goedgekeurd' en data aanpassen (als aanvaard) / of verwijderen als 
      // factuur proforma is en annulatie - als factuur reeds verstuurd dan nieuwe factuur met
      // negatief bedrag
      if ($data['wijzigstatus'] != 'geweigerd'){
        $ret = $this->wijzigdienst($wijzig);
        $bericht = $ret['bericht'];
      }
      else {
         $bericht = "Er werd niets gedaan, vermits de aanvraag geweigerd werd";
         $wijzig['wijzigstatus'] = 'geweigerd';
      }
      $wijzigs = Wijzig::create($wijzig);
      
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
          $hotel->status = 'wijzigingaanvraag';
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
                $hotel->status = "annulatieaanvraag";
                $hotel->save();
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
           $oudeFactuur_id = $factuur->id;
           
           $nieuweFactuur = new Factuur;
           $nieuweFactuur->id = 0;          
           $nieuweFactuur->factuurvolgnummer = null;
           $nieuweFactuur->datum = date('Y-m-d');
           $nieuweFactuur->jaar = date('Y');
           $nieuweFactuur->serviceable_id = $serviceid;
           $nieuweFactuur->serviceable_type = $servicetype;
           $nieuweFactuur->omschrijving = "van ".$wijzig['datumvan']." tot ".$wijzig['datumtot'];
           $nieuweFactuur->aantal = $factuur->aantal;
           $nieuweFactuur->prijs = $factuur->prijs;
           $nieuweFactuur->betaald = $factuur->betaald;
           $nieuweFactuur->referentie = null;
           $nieuweFactuur->save();
           $factuur->referentie = $nieuweFactuur->id;
           $factuur->save();
           $bericht = "Onze diensten zullen je contacteren";
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
//        dd("id = $id");
        
        $wijzig['serviceable_id'] = $id;
        $wijzig['serviceable_type'] = $type;
        // We halen de service op en maken er een afzonderlijke array van
        $hotel = [];
        $dagverblijf = [];
        $therapie = [];
        switch ($type){
            case 'hotel' :
              $hotelfiche = Hotel::findOrFail($id);
 //              dd($hotelfiche);
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
        $info['dagverblijf'] = $dagverblijf;
        $info['therapie'] = $therapie;
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
      
      session(['thisRequest' => $thisRequest]);
      session(['update' => 'update']);
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
      abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);    
      
      // haal alle aanvragen op
      $wijzig = Wijzig::all();     
      // toon deze
      return view('wijzig.admin.index', compact('wijzig'));
    }
    
    /**
     * Geef de details weer voor deze fiche (wijzig) - zodat admin kan 
     * aanpassen en aanvaarden of verwerpen
     *
     * hierbij moet je alle gegevens ook geven van service, factuur, klant en contactpersoon
     *
     * @param : id en type
     * @return : Response
     */
    public function adminDetail($id)
    {
      // dd('adminDetail id = '.$id);
      // enkel de admin mag hier komen
      abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);    
      
      // nu alle onderdelen opvragen
      // haal de wijzig van deze fiche
      $wijzig = Wijzig::findOrFail($id);
      $info['wijzig'] = $wijzig;
      $client = Helper::getClientFromServiceable($wijzig->serviceable_id, $wijzig->serviceable_type);
      $info['client'] = $client;      
      $info['contactpersoon'] = Contactpersoon::findOrFail($client->contactpersoon_id);
      $info['hotel'] = Hotel::findOrFail($wijzig->serviceable_id);
      $servicetype =  \App\Enums\ServiceType::getValue($wijzig->serviceable_type);
      $info['factuur'] = \App\Factuur::where([
            [ 'serviceable_id' , $wijzig->serviceable_id],
            [ 'serviceable_type', $servicetype ]
        ])->orderBy('id', 'asc')->get();
        
      $info['factuur']->mogelijknr = Helper::getFactuurnummer();
      $info['factuur']->mogelijkjaar = date('Y');       
      
      return view('wijzig.admin.detail', compact('info'));
    }
    
    /**
     *  We slaan de gegevens op die werden "aanvaard" door de admin
     *  en passen dus ook alle tabellen aan die hierdoor beïnvloed worden.
     *  Dat is wijzigs, service (hotels, dagverblijf of therapie), factuur
     *
     * @param : session?
     * @return : .
     */
    public function adminUpdate(Request $request, $id){
      $thisRequest = request()->all();
      $data = $thisRequest['data'];
      
      session(['thisRequest' => $thisRequest]);
      session(['data' => $data]);
      session(['adminupdate' => 'update']);
      // valideer
      $validator = Validator::make( $data, [
        'serviceable_id' => 'required | integer',
        'serviceable_type' => 'required',
        'rubriek' => 'required',
        'datumvan' => 'date',
        'datumtot' => 'date | after:datumvan',
        'wijzigstatus' => 'required',
      ])->validate();  
              
      // pas de diverse zaken aan
      // als geweigerd - dan moet je niets aanpassen
      $bericht = "Er werd niets gewijzigd, vermits je de wijziging geweigerd hebt";
      $info['status'] = 'geweigerd';
      if ($data['wijzigstatus'] != 'geweigerd'){
        // verander de wijzigstatus naar 'aanvaard'
        $wijzig = Wijzig::findOrFail($data['id']);
        $wijzig->wijzigstatus = 'aanvaard';
        $wijzig->rubriek = $data['rubriek'];
        $wijzig->datumvan = $data['datumvan'];
        $wijzig->datumtot = $data['datumtot'];
        $wijzig->save();
        // wijzig de status van de service naar 'goedgekeurd'
        $service = $this->changeStatusOfService($data);

        $bericht = "Je hebt de wijziging aanvaard! Bekijk nu nog eens de factuur om te zien of je moet aanpassen";
        $info['status'] = 'aanvaard';
      }
      // stuur e-mail naar info
      $info['rubriek'] = $data['rubriek'];
      Mail::to('info@devleugels.be')->send(new AdminWijzigMail($info));
     
      // bericht
      session()->flash('bericht', $bericht);
      $url = 'test';
      $url = 'wijzig/admin/'.$data['id'].'/detail';
      return ['message' => $url];         
    }
    
    /**
     * deze lokale functie wordt aanroepen door adminUpdate
     * past de status van de service aan - het wordt "goedgekeurd"
     *
     * @param $data
     * @return 
     *
     */
    public function changeStatusOfService($data)
    {
       $serviceabletype = \App\Enums\ServiceType::getValue($data['serviceable_type']);
        // We moeten nu nog de factuur (omschrijving) aanpassen
        // Gebruik de serviceable_id / serviceable_type om de laatste factuur te vinden
        $factuur = \App\Factuur::where([
            [ 'serviceable_id' , $data['serviceable_id']],
            [ 'serviceable_type', $serviceabletype ],
            [ 'referentie', null],
        ])->first();
               
       switch ($data['serviceable_type']){
         case 'hotel' :
           $hotel = Hotel::findOrFail($data['serviceable_id']);
           $hotel->status = "goedgekeurd";
           // pas ook de datumin en uit aan als rubriek = 'wijzig'
           if ($data['rubriek'] == 'wijziging'){
             $hotel->begindatum = $data['datumvan'];
             $hotel->einddatum = $data['datumtot'];
           }
           $hotel->save();
           
           // de factuur (omschrijving) aanpassen
           session(['factuur' => $factuur]);
          // maak nu een nieuwe omschrijving
          $omschrijving = "van ".$data['datumvan']." tot ".$data['datumtot'];

          $factuur->omschrijving = $omschrijving;
          $factuur->save();          
           break;
         case 'dagverblijf' :
           break;
         case 'therapie' :
           break;
       }
    }
}




