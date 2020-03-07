<?php

namespace App\Http\Controllers;

use App\Client;
use App\Contactpersoon;
use App\Mutualiteit;
use App\User;
use App\Enums\StatuutType;
use App\Factuur;
use Validator;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class ClientController extends Controller
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
        abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);
        
        $clients = DB::table('clients')->paginate(10);
        return view('clients-old.index', compact('clients')); 

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
     * Wordt opgeroepen vanuit het overzicht van de contactpersonen
     * Hier voegen we eenaantal zaken aan toe
     */
    public function createWithID($contactpersoon_id)
    {
        abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);
        
        $contactpersoon = Contactpersoon::findOrFail($contactpersoon_id);
        $mutualiteiten = Mutualiteit::all();
        
        $statuten = StatuutType::getInstances();

        $data = [
          'contactpersoon_id' => $contactpersoon_id,
          'contactpersoon_voornaam' => $contactpersoon['voornaam'],
          'contactpersoon_familienaam' => $contactpersoon['familienaam'],
          'contactpersoon_straat' => $contactpersoon['straat'],
          'contactpersoon_huisnummer' => $contactpersoon['huisnummer'],
          'contactpersoon_bus' => $contactpersoon['bus'],
          'contactpersoon_postcode' => $contactpersoon['postcode'],
          'contactpersoon_gemeente' => $contactpersoon['gemeente'],
          'contactpersoon_email' => $contactpersoon['email'],
          'contactpersoon_telefoon' => $contactpersoon['telefoon'],
          'contactpersoon_gsm' => $contactpersoon['gsm'],
          'contactpersoon_email' => $contactpersoon['email'],
         
          'mutualiteiten' => $mutualiteiten,
          
          'id' => 0,
          'voornaam' => '',
          'familienaam' => '',
          'straat' => '',
          'huisnummer' => '',
          'bus' => '',
          'postcode' => '',
          'gemeente' => '',
          'telefoon' => '',
          'gsm' => '',
          'email' => '',
          'password' => '',
          'geboortedatum' => '',
          'rrn' => '',
          'mutualiteit' =>'',
          'factuur_naam' => '',
          'factuur_straat' => '',
          'factuur_huisnummer' => '',
          'factuur_bus' => '',
          'factuur_postcode' => '',
          'factuur_gemeente' => '',
          'factuur_telefoon' => '',
          'factuur_gsm' => '',
          'factuur_email' => '',
          'statuut' => '',
          
          'statuten' => $statuten,
          'facturatiegegevens' => 0,
          
        ];
        $data = json_encode($data);
        //dd($data);
        return view('clients.create', compact('data'));         
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
             
        if ($data['facturatiegegevens'] == 0)
        {
            $naam = $data['voornaam']." ".$data['familienaam'];
            $data['factuur_naam'] = $naam;
            $data['factuur_straat'] = $data['straat'];
            $data['factuur_huisnummer'] =  $data['huisnummer'];
            $data['factuur_postcode'] =  $data['postcode'];
            $data['factuur_gemeente'] = $data['gemeente'];
        }
   
        $validator = Validator::make( $data, [
            'voornaam' => 'required | min:2',
            'familienaam' => ' required | min:2',
            'straat' => ' required | min:2',
            'huisnummer' => ' required',
            'postcode' => 'required',
            'gemeente' => 'required',
            'telefoon' => 'required_without:gsm',
            'gsm' => 'required_without:telefoon',
            'email' => 'email',
            
            'geboortedatum' => 'required | min : 6',
            'rrn' => 'required',
            'mutualiteit' => 'required',
            'statuut' => 'required',
            'facturatiegegevens' => 'required',
            
            'factuur_naam' => 'required',
            'factuur_straat' => 'required',
            'factuur_huisnummer' => 'required',
            'factuur_postcode' => 'required',
            'factuur_gemeente' => 'required',
            
        ])->validate();
 
        $naam = $data['voornaam']." ".$data['familienaam'];
        $crypted_password = bcrypt($data['password']);
        $user = array(
                 'name' => $naam,
                 'email' => $data['email'],
                 'password' => $crypted_password,
                 'admin' => 0
                );
        $thisUser = User::create($user);
        
        $mut = $data['mutualiteit'];
        $mut_id = \App\Mutualiteit::where('naam','=',$mut)->pluck('id')[0];
        
        $statuut_id = StatuutType::getValue($data['statuut']);
        
//        $mut_id = 1;
//        $statuut_id = 1;
        
        $client =  Client::create([
            'voornaam' => $data['voornaam'],
            'familienaam' => $data['familienaam'],
            'straat' => $data['straat'],
            'huisnummer' => $data['huisnummer'],
            'bus' => $data['bus'],
            'postcode' => $data['postcode'],
            'gemeente' => $data['gemeente'],
            'telefoon' => $data['telefoon'],
            'gsm' => $data['gsm'],
            'geboortedatum' => $data['geboortedatum'],
            'rrn' => $data['rrn'],
            'mutualiteit_id' => $mut_id,
            'factuur_naam' => $data['factuur_naam'],
            'factuur_straat' => $data['factuur_straat'],
            'factuur_huisnummer' => $data['factuur_huisnummer'],
            'factuur_bus' => $data['factuur_bus'],
            'factuur_postcode' => $data['factuur_postcode'],
            'factuur_gemeente' => $data['factuur_gemeente'],
            'factuur_email' => $data['factuur_email'],
            'statuut' => $statuut_id,
            'contactpersoon_id' => $data['contactpersoon_id'],
            'user_id' => $thisUser->id,
        ]);
   
        // NU OOK NOG openstaand van contactpersoon op 0 plaatsen
        DB::table('contactpersoons')
           ->where('id', $data['contactpersoon_id'])
           ->update(['openstaand' => 0]);
           
       // vermits we hier admin zijn en we verder zullen gaan
       // met de gegevens van een client moeten we deze client
       // bewaren in de session!
       session(['client_id' => $client->id]);            
        
         return ['message' => "clients"];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
  //      abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);

        session(['client_id' => $id]);
        $client = Client::findOrFail($id);
        $contactpersoon = Contactpersoon::findOrFail($client->contactpersoon_id); 
        $user = User::findOrFail($client->user_id);
  
 // $statuten = StatuutType::getKeys();
 // dd($statuten);      
        return view('clients.show', compact('client', 'contactpersoon', 'user')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        dd($client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
    
    /** de oude TE WISSEN **/
/*    public function showAsAdmin($id)
    {
        abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);
        
        $client = Client::findOrFail($id);
        $contactpersoon = Contactpersoon::findOrFail($client->contactpersoon_id);
        $user = User::findOrFail($client->user_id); 

        return view('clients.show', compact('client', 'contactpersoon', 'user'));
    }
 */   
    /**
     * Alternatieve functie showAsAdminBis waarin we hetzelfde
     * doen als bij showAsAdmin, maar met een andere layout
     */
    public function showAsAdmin($id)
    {
        abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);
        $client = Client::findOrFail($id);
        $contactpersoon = Contactpersoon::findOrFail($client->contactpersoon_id);
        $user = User::findOrFail($client->user_id); 

        return view('clients.show', compact('client', 'contactpersoon', 'user'));
    }
    
    /*
     * de functie aanmelden, zal gewoon de klant als klant in de
     * sessie definiëren, zodat we bewerkingen in zijn naam kan
     * doen.
     *
     * Deze bewerking mag je slechts uitvoeren als je als admin
     * aangemeld bent.
     *
     * voer eerst een controle uit of er een andere als klant is
     * aangemeld - als dat zo is, dan moet je die afmelden
     *
     * wellicht moet je de navbar herschrijven
     */
    public function aanmelden($id)
    {
        abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);

        // Is er een klant aangemeld?
        if ( request()->session()->has('client_id')){
            // ja, is het deze?
            $session_id = request()->session()->get('client_id');
            if ($id == $session_id)
                // hier kan je in principe niet komen
                return redirect()->action('ClientController@index');
            // meld de klant af
            request()->session()->pull('client_id', 'default');
        }
        
        // stel deze klant in
        session(['client_id' => $id]);
        
        return redirect('clients');
        
    }
    
    /*
     * de functie afmelden, meld de klant met  $id af, dat wil zeggen
     * dat je die uit de sessie verwijdert.
     *
     * misschien eerst testen of die aangemeld is?
     * 
     * wellicht moet je de navbar herschrijven
     */
    public function afmelden($id)
    {
       abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);
        
        request()->session()->pull('client_id', 'default');
        return redirect('clients');
        
    }
    
    /*
     * de functie hotelcreatie, vraagt de gegevens op voor een
     * reservatie voor deze klant. Dat zijn dus : begin- en einddatum,
     * de status (autom. aangevraagd ) en de prijs
     */
     public function hotelcreate($id)
     {
         // deze functie wordt aanroepen als je aangemeld bent, 
         // maar niet noodzakelijk admin
         
          $client = Client::findOrFail($id);
          return view('clients/hotelcreate', compact('client'));
     }
     
     /* de calendar */
     public function calendar($id)
     {
         // Zoek alle hotels voor deze klant
         $query = "SELECT * FROM serviceables WHERE client_id=".$id." AND serviceable_type like '%Hotel'";
         $hotels = DB::select($query);
         // dd($hotels);
         if (sizeOf($hotels) == 0)
         {
             $results = [];
         } else {
             $indexes = [];
             foreach( $hotels as $hotel)
             {
                 $indexes[] = $hotel->serviceable_id;
             }
             $index = "(".implode(",",$indexes).")";
             // indien er geen index is
    
             $services = DB::select('SELECT * FROM hotels WHERE id in '.$index);
             // maak nu een record en voeg toe aan resultaat array
             // de record bevat begindatum, einddatum, kamer_id ( haal kamernummer), status, bedrag
             $results= [];
             foreach( $services as $service)
             {
                 // dd($service);
                 $result= [];
                 $result['id'] = $service->id;
                 $result['begindatum'] = $service->begindatum;
                 $result['einddatum'] = $service->einddatum;
                 $kamer = DB::select('SELECT kamernummer from kamers where id ='.$service->kamer_id);             
                 $result['kamernummer'] = $kamer[0]->kamernummer;
                 $result['status'] = $service->status;
                 $result['bedrag'] = $service->bedrag;
    //             dd($result);
                 $results[] = $result;               
             }
         }
   
         return view('calendar/indexClientHotel', compact('results'));
     }   
     
     /** overzicht van de client **/
     public function over(){
        $thisRequest = request()->all();
        $data = $thisRequest['data'];     
        

        $validator = Validator::make( $data, [
            'voornaam' => 'required | min : 2',
            'familienaam' => 'required | min : 2',
            'straat' => 'required | min : 2',  
            'huisnummer' => 'required',
            'postcode' => 'required | numeric',
            'gemeente' => 'required ',
            'telefoon' => 'required_without :gsm| nullable',
            'gsm' => 'required_without :telefoon| nullable',
            'geboortedatum' => 'required | date',
            'rrn' => 'required | regex : /[0-9]{2}.[0-9]{2}.[0-9]{2}-[0-9]{3}.[0-9]{2}/',
            'mutualiteit' => 'required',
            'statuut' => 'required',
        ])->validate();     
        
        // We bekijken de mutualiteit !!!
          $data['mutualiteit_id'] = DB::table('mutualiteits')->where('naam', $data['mutualiteit'])->get()->first()->id;

        // het statuut : de key wijzigen door de value gebeurt automatisch hieronder.
 
         // spaar nu de gegevens
         DB::table('clients')
            ->where('id', $data['client_id'])
            ->update(
                [
                    'voornaam' => $data['voornaam'],
                    'familienaam' => $data['familienaam'],
                    'straat' => $data['straat'],
                    'huisnummer' => $data['huisnummer'],
                    'postcode' => $data['postcode'],
                    'gemeente' => $data['gemeente'],
                    'telefoon' => $data['telefoon'],
                    'gsm' => $data['gsm'],
                    'geboortedatum' => $data['geboortedatum'],
                    'rrn' => $data['rrn'],
                    'mutualiteit_id' => $data['mutualiteit_id'], // als veranderd?
                    'statuut' => StatuutType::getValue($data['statuut']),
                ]);              


         $url = 'clients/'.$data['client_id'];
         return ['message' => $url];
     } 
     
     /**
      * Wachtwoordwijzigen - met de gegeven klant e-mail gaan we nu op zoek naar
      * het e-mail adres van de contactpersoon.
      * Naar die persoon sturen we een mail met de vraag om binnen het uur te 
      * antwoorden op deze mail door op de meegegeven link te klikken - Die link
      * zullen we ondertussen bewaren in het Laravelsysteem
      */
     public function wachtwoordwijzig()
     {
        $thisRequest = request()->all();       
        
  //      dd($thisRequest);     
        
        return redirect('password/reset')  ;
     }
     
     /**
      * functie contactpersoon valideert de waarden van deze contactpersoon
      * en update dan ook de databank. Let wel: het is verschillend voor admin 
      * als voor de klant
      */
     public function contactpersoon()
     {
        $thisRequest = request()->all();
        $data = $thisRequest['data'];
        
         $validator = Validator::make( $data, [
            'voornaam' => 'required | min : 2',
            'familienaam' => 'required | min : 2',
            'straat' => 'required | min : 2',  
            'huisnummer' => 'required',
            'postcode' => 'required | numeric',
            'gemeente' => 'required ',
            'telefoon' => 'required_without :gsm|nullable',
            'gsm' => 'required_without :telefoon|nullable',
            'openstaand' => 'required',
        ])->validate();           
        
         DB::table('contactpersoons')
            ->where('id', $data['id'])
            ->update(
                [
                    'voornaam' => $data['voornaam'],
                    'familienaam' => $data['familienaam'],
                    'straat' => $data['straat'],
                    'huisnummer' => $data['huisnummer'],
                    'postcode' => $data['postcode'],
                    'gemeente' => $data['gemeente'],
                    'telefoon' => $data['telefoon'],
                    'gsm' => $data['gsm'],
                    'openstaand' => $data['openstaand']
                ]);               
        
        /* vergeet de client_id niet */
         $url = 'clients/'.$data['client_id'];
         return ['message' => $url];                 
     }
     
     /*** function factuur waar we de factuur opstellen voor de klant ***/
     public function factuur()
     {
         $thisRequest = request()->all();
         $data = $thisRequest['data']; 
        // dd($request);
        
        // hieronder sturen we door ... maar enkel om het te kunnen bekijken
        
        request()->session()->flush();
        request()->session()->put('client_id' ,$data['client_id']);
        request()->session()->push('hotels', $data['hotels']);
        request()->session()->push('dagverblijf', $data['dagverblijf']);
        request()->session()->push('therapie', $data['therapie']);
        
        // hier de validatie toevoegen?
        
        // De factuur samenstellen
        // haal de naam
        
         
         $url = 'clients/'.$data['client_id'];
         $url = 'clients/factuurview';
         return ['message' => $url];
     }
     
     public function factuurview()
     {
         $request = request()->all();
         $data = request()->session()->all();
 //        dd($data);
 
         // We beginnen met de algemene data voor deze klant
         // haal de factuurgegevens voor deze klant
         $klant = DB::table('clients')->where('id', $data['client_id'])->get()->first();
         
         $info = [];
         $info['client_id'] = $data['client_id'];
         $info['factuur_naam'] = $klant->factuur_naam;
         $info['factuur_straat'] = $klant->factuur_straat;
         $info['factuur_huisnummer'] = $klant->factuur_huisnummer;
         $info['factuur_bus'] = $klant->factuur_bus; 
         $info['factuur_postcode'] = $klant->factuur_postcode; 
         $info['factuur_gemeente'] = $klant->factuur_gemeente; 
         $info['factuur_email'] = $klant->factuur_email;
         
         // nu halen we de gegevens van De Vleugels zelf op
         $vleugels = DB::table('algemeens')->where('id',1)->get()->first();
         $info['vleugels_afzendernaam'] = $vleugels->factuur_afzendernaam;
         $info['vleugels_afzenderstraatennummer'] = $vleugels->factuur_afzenderstraatennummer;
         $info['vleugels_afzenderZipenGemeente'] = $vleugels->factuur_afzenderZipenGemeente;
         $info['vleugels_afzenderTelefoon'] = $vleugels->factuur_afzenderTelefoon;
         $info['vleugels_afzenderEmail'] = $vleugels->factuur_afzenderEmail;
         $info['vleugels_iban'] = $vleugels->iban;
         $info['vleugels_bic'] = $vleugels->bic;
         
         // nu halen we het factuurnummer op
         $jaar = date("Y");
         $info['factuur_jaar'] = $jaar;
         // dd($jaar);
         $volgnummer = Factuur::where('jaar', $jaar);
         $aantal = $volgnummer->count();
         if ( $aantal == 0)
            $factuurvolgnummer = 1;
         else {
            $hoogste = $volgnummer->max('factuurvolgnummer');
            $factuurvolgnummer = $hoogste + 1;
         }
         // dd($factuurvolgnummer);
         $info['factuur_volgnummer'] = $factuurvolgnummer;
         $info['factuur_datum'] = date("d-m-Y");
         
         // Nu komen de onderscheiden activiteiten
         $info['hotels'] = $this->getHotelInfo($data['hotels'][0]);
         $info['dagverblijf'] = null;
         $info['therapie'] = null;
 //        dd($info);
                                                
        $pdf = PDF::loadView('clients.myPDF', $info);
        $pdf->save('facturen/factuur'.$info['factuur_jaar'].'-'.$info['factuur_volgnummer'].'.pdf');
        
        // Spaar de factuur in de databank
        foreach ($info['hotels'] as $hotel){
            $factuur = new Factuur;
            $factuur->factuurvolgnummer = $factuurvolgnummer;
            $factuur->jaar = $jaar;
            $factuur->datum = Carbon::parse($info['factuur_datum'])->format('Y-m-d');

            $factuur->serviceable_id = $hotel['hotel_id'];    
            $factuur->serviceable_type = 'App\Hotel';
            $factuur->omschrijving = 'Verblijf in hotel van '.$hotel['begindatum'].' tot '.$hotel['einddatum'];
            $factuur->aantal =   1;
            $factuur->prijs = $hotel['bedrag'];
            
            // stel de status van deze hotel_id op 'goedgekeurd'
            DB::table('hotels')->where('id', $hotel['hotel_id'])->update(['status' => 'goedgekeurd']);
        }
        
        $factuur->save();

        // stel nu de status van de betreffende hotels, dagverblijfs en therapie van "aangevraagd" naar "goedgekeurd"
        
        return $pdf->save('temp/testpdf.pdf')->stream('teststream.pdf');
  
//         return view('clients/fiches/factuurview', compact('info'));
     }
     
     /***
      * function getHotelInfo returns an array of items that has to be entered in the envoice
      *
      */
     public function getHotelInfo($hotels)
     {
         $ret = [];
         // enkel de hotels met hotelchoice = true worden teruggestuurd
         foreach( $hotels as $hotel)
         {
             if ($hotel['hotelchoice'] == true){
               $ret[] = $hotel;
           //    dd($hotel);
             }
         }
         return $ret;
     }
    
}
