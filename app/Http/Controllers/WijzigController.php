<?php

namespace App\Http\Controllers;

use App\Wijzig;
use Illuminate\Http\Request;
use App\Hotel;
use App\Client;
use App\Contactpersoon;
use App\Helper;

class WijzigController extends Controller
{
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
        //
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
        
        // We halen de service op en maken er een afzonderlijke array van
        switch ($type){
            case 'hotel' :
              $hotel = Hotel::findOrFail($id)->first();
              $info['service'] = $hotel;
              break;
            case 'dagverblijf':
              break;
            case 'therapie':
              break;
        }
        
        // maak nu een blanko Wijzig
        $wijzig['id'] = 0;
        $wijzig['serviceable_id'] = $id;
        $wijzig['serviceable_type'] = \App\Enums\ServiceType::getValue($type); 
        $wijzig['rubriek'] = 'wijziging';
        $wijzig['datumvan'] = null;
        $wijzig['datumtot'] = null;
        $info['wijzig'] = $wijzig;
        
        $client = Helper::getClientFromServiceable($id,$type);
        $info['service']['client'] = $client;
        
        $info['service']['contactpersoon'] = Contactpersoon::where('id', $client->contactpersoon_id)->get()->first();

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
    public function update(Request $request, Wijzig $wijzig)
    {
        //
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
}
