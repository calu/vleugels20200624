<?php

namespace App\Http\Controllers;

use App\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Helper;
use App\Client;
use App\Kamer;
use App\Contactpersoon;
use App\HotelWijzig;
use App\Serviceable;
use App\Mijntemp;
use App\Mail\WijzigHotelMail;
use App\Mail\bevestigWijzigingmail;
use Illuminate\Support\Facades\Mail;

class HotelController extends Controller
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
        // ieder aangemelde client mag hier binnenkomen
        // We halen de client_id op uit de sessie
         $client_id = Helper::getClient();
         $vandaag = date("Y-m-d");
         
         // We bereiden het formulier voor
         $info['id'] = 0;
         $info['client_id'] = $client_id;
         $info['begindatum'] = $vandaag;
         $info['einddatum'] = $vandaag;
         
         $info = json_encode($info);
         
         // We zoeken alle reservatievragen van deze klant voor hotelovernachting
         /*
          * in serviceables zoek je de serviceable_id voor deze klant die App\Hotel als serviceable_type hebben
          * daarmee zoeken we nu de entries in tabel Hotels
          */
          $serviceable_ids = DB::table('serviceables')->where([['serviceable_type', 'App\Hotel'], ['client_id', $client_id]])->get();
          $hotels = collect([]);
          if (!$serviceable_ids->isEmpty()){
              foreach ($serviceable_ids as $service)
              {
                  $serviceable_id[] = $service->serviceable_id;           
    //              dd($serviceable_id);
              }
              $hotels = DB::table('hotels')->whereIn('id', $serviceable_id)->get();
     //         dd($hotels);
          }
         
         return view('hotelreservatie/index', compact('info', 'hotels'));
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
    public function store(Request $request)
    {
       // session(['request' => $request]);
        $thisRequest = request()->all();
        $data = $thisRequest['data'];
        session(['data' => $data]);       
        
        // Validatie bekijken
//        $morgen = date("Y-m-d", strtotime("+1 day"));
        $validator = Validator::make( $data, [
            'begindatum' => 'required | date | after:tomorrow',
            'einddatum' => 'required| date | after:begindatum'
         ])->validate();        
        
        // als ok dan spaar het op met extra info 
        // serviceable - en kamer_id, status en bedrag
        $info['begindatum'] = $data['begindatum'];
        $info['einddatum'] = $data['einddatum']; 
        $info['kamer_id'] = 1;
        $info['status'] = 'aangevraagd';
        $info['bedrag'] = 0;
        
        $hotel = \App\Hotel::create($info);
        $client = \App\Client::findOrFail($data['client_id']);
        $hotel->service($client);
        
        session()->flash('bericht', 'Je aanvraag werd geregistreerd. Binnenkort contacteren we je voor bevestiging');        
        
        $message = "home";
        return ['message' => $message];
    }
    
    public function store_old(Request $request)
    {
        $request->validate([
            
        ]);
        
        $data = $request->all();
        $data['kamer_id'] = 1;
        $data['service_id'] = 1;

        $hotel = \App\Hotel::create($data);
        $client = \App\Client::find($request->client_id);
        $hotel->service($client);
        
        session()->flash('bericht', 'De nieuwe mutualiteit werd toegevoegd');
        
        $return = 'clients/'.$request->client_id;
        return redirect($return);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function show(Hotel $hotel)
    {
        // iedereen die aangemeld is, mag hier komen
        // Er zullen wel 2 versies zijn -- naargelang klant of admin
        return view('hotelreservatie.fiches.detail', compact('hotel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function edit(Hotel $hotel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
/*****     
    public function update(Request $request, Hotel $hotel)
    {
        //
    }
***/

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hotel $hotel)
    {
        //
    }
    
    public function reserveer(Request $request)
    {
        $data = $request->all();
 //       dd($request->input('begindatum'));
 //       dd("HotelController@reserveer stop".implode($data));
        
        
        $request->validate([
            'begindatum' => 'required | date | after : tomorrow ',
            'einddatum' => 'required | date | after : begindatum',
            'kamernummer' => ' required | integer ',
        ]);
        
        // zoek de kamer_id waarvan hier het nummer is gegeven
         $entry = DB::table('kamers')->where('kamernummer', $request->input('kamernummer'));
        
        if ( $entry->exists()){
            $kamer_id = $entry->get()->first()->id;

        }
        else {
            // dit mag niet gebeuren
            $kamer_id = 0;
            dd("dit mag niet gebeuren");
        }
        
        
        $hoteldata['begindatum'] = $request->input('begindatum');
        $hoteldata['einddatum'] = $request->input('einddatum');
        $hoteldata['kamer_id'] = $kamer_id;
        $hoteldata['status'] = 'aangevraagd';
        $hoteldata['bedrag'] = 0;

        $hotel = \App\Hotel::create($hoteldata);
        $client = \App\Client::find($request->client_id);
        $hotel->service($client);
        
        session()->flash('bericht', 'De nieuwe reservatie werd toegevoegd');
        
        $return = 'clients/'.$request->client_id;
        return redirect($return);      
    }
    
    public function wijzig($hotel)
    {
        $thisRequest = request()->all();
        // dd($thisRequest);
        // dd($thisRequest['wijziging']);
        // Nu maak je een mail dat je verstuurt naar vleugels
        $this->zendMail($thisRequest);
        
        // Sla de data op in de tabel hotel_wijzigs
        $HotelWijzig = new HotelWijzig();
        $HotelWijzig->hotel_id =  $thisRequest['hotel_id'];
        $HotelWijzig->rubriek = 'wijziging';
        $HotelWijzig->wijziging = $thisRequest['wijziging'];
        $HotelWijzig->save();     
           
        // wijzigingnaanvraag als status instellen
        $wijziging = Hotel::findOrFail($hotel);
        $wijziging->status = "wijzigingaanvraag";
        $wijziging->save();

        
        // stuur een flash bericht 
        session()->flash('bericht', 'De aanvraag voor wijziging werd goed ontvangen. We nemen binnenkort contact op');
        // keer nu terug naar hoofdpagina
        return redirect('home');
    }
    
    /** function zendMail verstuurt een mail naar de info@devleugels
     *  met daarin de inhoud van de vraag zoals aangevraagd
     *
     * @param : $data is hetgeen van het formulier werd gestuurd
     */
    public function zendMail($data)
    {
 //       dd($data);
        // haal het e-mail adres van de vleugels op
        $email = DB::table('algemeens')->get()->first()->factuur_afzenderEmail;        
        // De klant die het aanvraagt
        $client = \App\Client::find($data['client_id']);    
        $info['klantVolleNaam'] = $client->voornaam." ".$client->familienaam;  
        // de contactpersoon nu opzoeken ( voor- en familienaam en e-mail )
   //     dd($client);
        $contactpersoon = Contactpersoon::findOrFail($client->contactpersoon_id);
        $info['contactVolleNaam'] = $contactpersoon->voornaam." ".$contactpersoon->familienaam;
        $info['contactEmail'] = $contactpersoon->email;
        if ($contactpersoon->bus == null)
            $bus = "";
        else
            $bus = "bus ".$contactpersoon->bus;
        $info['adres1'] = $contactpersoon->straat.",".$contactpersoon->huisnummer." ".$bus;
        $info['adres2'] = $contactpersoon->postcode." ".$contactpersoon->gemeente;
        $info['telefoon'] = $contactpersoon->telefoon;
        $info['gsm'] = $contactpersoon->gsm;
        $info['rubriek'] = "wijzig reservatie";
        
        $hotel = \App\Hotel::findOrFail($data['hotel_id']);
        // dd($hotel->begindatum);
        $info['begindatum'] =$hotel->begindatum;
        $info['einddatum'] = $hotel->einddatum;
        $info['wijzigingvraag'] = $data['wijziging'];
        
        // dd($info);

        Mail::to($email)->send(new WijzigHotelMail($info));
    } 
    
    /**
     * admin_wijzig_annul
     *
     * Deze functie geeft een overzicht van de hotel aanvragen
     * voor wijziging of annulatie.
     * 
     */
    public function admin_wijzig_annul()
    {
        abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);        
        
        $wijzigingen = HotelWijzig::where('rubriek', 'wijziging')->get();
        $annulaties = HotelWijzig::where('rubriek', 'annulatie')->get();
        
        // dd($wijzigingen);
        return view('hotelreservatie.admin.index', compact('wijzigingen','annulaties'));
    }
    
    /**
     * admin_toon_wijzig
     * haalt de nodig info van hotel op en 
     * gaat dan naar views.hotelreservatie.fiches.detailwijzig
     */
    public function admin_toon_wijzig($id)
    {
        // enkel admin mag dit doen
        abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);
        
        // We halen de entry HotelWijzig op, om er de hotel_id uit te halen
        $hotelwijzig = HotelWijzig::findOrFail($id);
        $hotel = Hotel::findOrFail($hotelwijzig->hotel_id);

        $client_id = DB::table('serviceables')->where('serviceable_id', $hotelwijzig->hotel_id)->get()->first()->client_id;
        $client = Client::findOrFail($client_id);
        $contactpersoon = Contactpersoon::findOrFail($client->contactpersoon_id);


        $info['wijzig_id'] = $hotelwijzig->id;
        $info['wijzig_rubriek'] = $hotelwijzig->rubriek;
        $info['wijzig_wijziging'] = $hotelwijzig->wijziging;

        
        $info['client_id'] = $client->id;
        $info['client_vollenaam'] = $client->voornaam." ".$client->familienaam;
        
        $info['contactpersoon_id'] = $contactpersoon->id;
        $info['contactpersoon_vollenaam'] =$contactpersoon->voornaam." ".$contactpersoon->familienaam;
        if ($contactpersoon->bus == null)
          $bus = "";
        else
          $bus = " BUS : ".$contactpersoon->bus;
        $info['contactpersoon_adres1'] = $contactpersoon->straat.",".$contactpersoon->huisnummer.$bus;
        $info['contactpersoon_adres2'] = $contactpersoon->postcode." ".$contactpersoon->gemeente;
        $info['contactpersoon_telefoon'] = $contactpersoon->telefoon;
        $info['contactpersoon_gsm'] = $contactpersoon->gsm;
        $info['contactpersoon_email'] = $contactpersoon->email;
                
        $info = json_encode($info);
        session(['hotelwijzig' => $id]);

        return view('hotelreservatie.fiches.detailwijzig', compact('hotel','info'));        
    }
    
    
    /** admin_store_wijzig
     * hier komen we waarschijnlijk nooit terecht
     *
     */
    public function admin_store_wijzig_oud()
    {
        session(['request' => 'admin_store_wijzig']);
        
        $message = "test";
        return ['message' => $message];
    }
    
    public function admin_update_wijzig($id)
    {
       // enkel admin
       abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);
       
       $thisRequest = request()->all();
       $data = $thisRequest['data'];
       $origdata = Hotel::where('id', $id)->get();
        
       $validator = Validator::make( $data, [
           'begindatum' => 'required | date | after : tomorrow',
           'einddatum' => 'required | date | after : begindatum',
           'kamer_id' => ' required | integer ',
           'bedrag' => 'required | numeric',
        ])->validate();
        
        /* We moeten 4 zaken opslaan
        *   begin en einddatum 
        *   bedrag en kamer_id in hotels
        * maar ook status terug als "goedgekeurd"
        * misschien ook nieuwe factuur verzenden
        * ook entry in hotel_wiizigs verwijderen
        * dan melden als aangepast, met misschien een e-mail
        */
       
       // stel de status op goedgekeurd 
       // sla de hotel gegevens op
       $hotel = Hotel::where('id', $id)
         ->update([
             'begindatum' => $data['begindatum'],
             'einddatum' => $data['einddatum'],
             'kamer_id' => $data['kamer_id'],
             'bedrag' => $data['bedrag'],
             'status' => 'goedgekeurd'
         ]);

       // verwijder de entry in hotel_wijzigs 
       $hotelwijzigen = request()->session()->all();
       $hotelwijzig = HotelWijzig::findOrFail($hotelwijzigen['hotelwijzig']);
       // Een mail versturen met de details van de wijziging
       $contactmail = $this->bevestigWijzigingMail($data, $hotelwijzig, $origdata);

       // TODO uiteindelijk wordt : HotelWijzig::destroy($hotelwijzigen['hotelwijzig']);
       HotelWijzig::destroy($hotelwijzigen['hotelwijzig']);
       // TODO ?? eventueel een factuur versturen
        
       // melden als aangepast (flash) - en misschien ook een e-mail
       $bericht = "wijziging uitgevoerd.";
       if (!$contactmail) $bericht .= " de contactpersoon heeft geen mail, dus naar info gestuurd";
       session()->flash('bericht', 'De wijziging werd uitgevoerd ....');
            

 //      session(['thisRequest' => $thisRequest ]);
       
 //      $testje = request()->session()->all();
       
 //      session(['hotelwijzig' => $hotelwijzig ]);
       
       $message = "hotelreservatie/adminwijzig";
       return ['message' => $message];         
    }
    
    public function bevestigWijzigingMail($data, $hotelwijzig, $origdata)
    {
        // Hier halen we alle gegevens op om een
        // email te sturen naar de klant
        // data bevat 
        
        // e-mail adres contactpersoon
        //   met de hotel_id uit $hotelwijzig halen we client_id uit serviceables
        $client_id = DB::table('serviceables')->where('serviceable_id', $hotelwijzig->hotel_id)->get()->first()->client_id;
        $client = Client::findOrFail($client_id);
        $contactpersoon = Contactpersoon::findOrFail($client->contactpersoon_id);
        $email = $contactpersoon->email;
        
        $info['contactpersoon_vollenaam'] = $contactpersoon->voornaam." ".$contactpersoon->familienaam;
        $info['wijzigaanvraag'] = $hotelwijzig->wijziging;
        $info['client_vollenaam'] = $client->voornaam." ".$client->familienaam;
        $temp = $origdata->first();
        $info['oorspronkelijkedata'] = "van ".$temp->begindatum." tot ".$temp->einddatum;
        $info['begindatum'] = $data['begindatum'];
        $info['einddatum'] = $data['einddatum'];
        $kamer = Kamer::findOrFail($data['kamer_id']);
        $info['kamernummer'] = $kamer->kamernummer;
        $info['bedrag'] = $data['bedrag'];
        
        // nu alles uit algemeens
 
        $algemeen = DB::table('algemeens')->get()->first();
        $info['vleugels_adres1'] = $algemeen->factuur_afzenderstraatennummer;
        $info['vleugels_adres2'] = $algemeen->factuur_afzenderZipenGemeente;
        $info['vleugels_telefoon'] = $algemeen->factuur_afzenderTelefoon;
        $info['vleugels_email'] = $algemeen->factuur_afzenderEmail;
        
        // nu zend je de mail
        /*als de contactpersoon geen mail heeft .... stuur naar info */
        $return = true;
        if (empty($email)){
//            stuur de mail naar de info
            $email = $info['vleugels_email'];
            $return = false;
        }
        Mail::to($email)->send(new bevestigWijzigingMail($info));
        
  /*      session(['mail1' => $contactpersoon]);
        session(['mail2' => $data]);
        session(['mail3' => $origdata]);
        session(['mail4' => $info]);
        session(['test' => $algemeen]); */
        return $return; // false als geen mail kan verstuurd worden
    }
    
    
}
