<?php

namespace App\Http\Controllers;

use App\Client;
use App\Contactpersoon;
use App\Mutualiteit;
use App\User;
use App\Enums\StatuutType;
use Validator;
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
        return view('clients.index', compact('clients'));

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
        return view('clients.show', compact('client', 'contactpersoon', 'user'));
        // contactpersoon_id en user_id ook ophalen
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
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
    
}
