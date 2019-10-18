<?php

namespace App\Http\Controllers;

use App\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

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
    public function store(Request $request)
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
        //
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
    public function update(Request $request, Hotel $hotel)
    {
        //
    }

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
}
