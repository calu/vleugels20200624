<?php

namespace App\Http\Controllers;

use App\Vraag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Vragentype;
use DateTime;
use App\Helper;
use Validator;

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
        $vandaag = new DateTime('NOW');
 //       $vandaag = date_format($vandaag, 'j-n-Y');
        $vandaag = date_format($vandaag, 'Y-n-i');
  
        
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
}
