<?php

namespace App\Http\Controllers;

use App\Vraag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Vragentype;
use DateTime;
use App\Helper;
use App\Client;
use App\Contactpersoon;
use Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\AntwoordMail;

class VraagController extends Controller
{
    public function __construct(){
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
        
        $onbeantwoord = DB::table('vraags')->where('status', 'aangevraagd')->paginate(10);
        $beantwoord = DB::table('vraags')->where('status', 'beantwoord')->paginate(10);
        
        return view('vragen.index', compact('onbeantwoord', 'beantwoord'));       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // haal de vraagtypes op
        $types = Vragentype::all();
        $vragentypes = [];
        foreach($types as $type){
            array_push($vragentypes,['id' => $type->id, 'vraagtype' => $type->vraagtype]);
        }
                
        // we halen nu de client_id op 
        $client_id = Helper::getClient();
        $vandaag = date("Y-m-d");

  
        
        $vraag = array(
            'id' => 0,
            'vraagsteller' => $client_id,
            'vraagtype' => 1,
            'vraag' => '',
            'status' => 'aangevraagd',
            'datumvraag' => $vandaag,
            'datumantwoord' => null,
            'antwoord' => ''
        );
        
        $vragentypes = json_encode($vragentypes);
        $vraag = json_encode($vraag);
        
        return view('vragen.create', compact('vraag','vragentypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $thisRequest = request()->all();
        $data = $thisRequest['data'];
        
        $validator = Validator::make( $data, [
            'datumvraag' => 'required | min:2',
            'status' => 'required',
            'vraagsteller' => 'required',
            'vraag' => 'required | min : 5',
            'vraagtype' => 'required',
         ])->validate();
        
        $vraag = Vraag::create([
            'vraagsteller' => $data['vraagsteller'],
            'vraagtype' => $data['vraagtype'],
            'vraag' => $data['vraag'],
            'datumvraag' => $data['datumvraag'],                                 
        ]);
        
         session()->flash('bericht', 'De gegevens werden verstuurd. We nemen binnenkort contact op');  
         return ['message' => 'home'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vraag  $vraag
     * @return \Illuminate\Http\Response
     */
    public function show(Vraag $vraag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vraag  $vraag
     * @return \Illuminate\Http\Response
     */
    public function edit(Vraag $vraag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vraag  $vraag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vraag $vraag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vraag  $vraag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vraag $vraag)
    {
        //
    }
    
    /**
     * beantwoord de vraag die wordt gesteld
     *
     * @param $id - de vraag id
     * @return een view
     */
    public function antwoord($id)
    {
        // enkel admin mag antwoorden
        abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);        

        $vraag = Vraag::where('id', $id)->get()->first();
        $info = [];
        // nu halen we nog wat extra info op
        $vraagsteller = Client::where('id', $vraag->vraagsteller)->get()->first();
        $info['vraagsteller'] = $vraagsteller->voornaam." ".$vraagsteller->familienaam;
        $info['vraagtype'] = Vragentype::where('id', $vraag->vraagtype)->get()->first()->vraagtype;
        $info['id'] = $vraag->id;
        $info['vraagsteller_id'] = $vraag->vraagsteller;
        $info['vraagtype_id'] = $vraag->vraagtype;
        $info['vraag'] = $vraag->vraag;
        $info['status'] = $vraag->status;
        $info['datumvraag'] = $vraag->datumvraag;
        $info['datumantwoord'] = $vraag->datumantwoord;
        $info['antwoord'] = $vraag->antwoord;
       // dd($info);
        return view('vragen.antwoord', compact('info'));
    }
    
    /** antwoordStore
     * Slaat de gegevens van een nieuwe vraag op ...
     */
    public function antwoordStore()
    {
        return ['message' => "home"];
    }
    
    /** antwoordUpdate
     *    voert een update uit van dit record
     *  @param : id - id of this record
     */
    public function antwoordUpdate($id)
    {
        // enkel admin mag antwoorden
        abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);  
        
        $thisRequest = request()->all();
        $data = $thisRequest['data'];
        
        $validator = Validator::make( $data, [
            'antwoord' => 'required | min : 5',
        ])->validate();
        
        // een mail versturen naar de contactpersoon
        $answer = $this->zendMail($data);
// session(['answer'=> $data]);
// return ['message' => 'test'];
        // Hier nu alles opslaan
        $vraag = Vraag::findOrFail($id);
        // datumantwoord invullen op vandaag
        $response['antwoord'] = $answer['antwoord'];
        

        $vandaag = date("Y-m-d");
        $response['datumantwoord'] = $vandaag;
        // status invullen
        $response['status'] = 'beantwoord';
        
        $vraag->update($response);
        
        // flash sturen
        $bericht = "Een antwoord werd verstuurd naar ".$answer['contactpersoonnaam'];
        session()->flash('bericht', $bericht);
        return ['message' => 'vraag'];

    }
    
    /** zendMail
     * is een hulpfunctie waarmee we een mail versturen naar
     * de contactpersoon van deze klant met o.a. het antwoord op zijn vraag
     */
    public function zendMail($data)
    {
        // Zoek de naam van de contactpersoon
        $contactpersoon_id = Client::findOrFail($data['vraagsteller_id'])->get()->first()->contactpersoon_id;
        $info['contactpersoon_id'] = $contactpersoon_id;
        $contactpersoon = Contactpersoon::findOrFail($contactpersoon_id);
        // haal het e-mail adres van de contactpersoon
        $info['email'] = $contactpersoon->email;
        // Haal de naam van de klant
        $info['klantnaam'] = $data['vraagsteller'];
        // vraag
        $info['vraag'] = $data['vraag'];
        $info['vraagdatum'] = $data['datumvraag'];
        $info['antwoord'] = $data['antwoord'];
        $info['contactpersoonnaam'] = $contactpersoon->voornaam." ".$contactpersoon->familienaam;
        $info['vleugelstelefoon'] = DB::table('algemeens')->get()->first()->factuur_afzenderTelefoon;
        
        // Haal nu het emailadres van de contactpersoon op
        Mail::to($contactpersoon->email)->send(new AntwoordMail($info));
        
        
        return $info;
    }
    
    /** detail
     *    geeft de volledige inhoud van een vraag/antwoord weer
     *  @param : id -- de id van de vraag
     */
    public function detail($id){
        // enkel admin mag antwoorden
        abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);  
                
        $vraag = Vraag::where('id', $id)->get()->first();
 //       dd($vraag);
        
        // naam vraagsteller
        $vraagsteller = Client::where('id', $vraag->vraagsteller)->get()->first();
        $vraag['vraagstellernaam'] = $vraagsteller->voornaam." ".$vraagsteller->familienaam;       
        // type vraag
        $vraag['vraagtypenaam'] = Vragentype::where('id', $vraag->vraagtype)->get()->first()->vraagtype;
       
        
        return view('vragen.detail', compact('vraag'));
    } 
}
