<?php

namespace App\Http\Controllers;

use App\Contactpersoon;
use Illuminate\Http\Request;
// use App\Http\Requests\ContactpersoonRequest;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactpersoonMail;

class ContactpersoonController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth', ['except' => ['create', 'store','mail']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);
        
        $contactpersonenOpen = DB::table('contactpersoons')->where('openstaand', 1)->paginate(10);      
        $contactpersonenGesloten = DB::table('contactpersoons')->where('openstaand', 0)->paginate(10);
        return view('contactpersoon.index', compact(['contactpersonenOpen', 'contactpersonenGesloten']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vraag = array(
            'id' => 0,
            'voornaam' => '',
            'familienaam' => '',
            'relatie' => '',
            'straat' => '',
            'huisnummer' => '',
            'bus' => '',
            'postcode' =>'',
            'gemeente' =>'',
            'telefoon' =>'',
            'gsm' =>'',
            'email' =>'',
            'rubriek' => '',
            'vraag' => '',    
            'openstaand' => 1,            
          );
          $vraag = json_encode($vraag);
        return view('contactpersoon.create', compact('vraag'));
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
 //        dd($data);

        $validator = Validator::make( $data, [
            'voornaam' => 'required | min:2',
            'familienaam' => ' required | min:2',
            'relatie' => 'required | min:2',
            'straat' => ' required | min:2',
            'huisnummer' => ' required',
            'postcode' => 'required',
            'gemeente' => 'required',
            'telefoon' => 'required_without:gsm',
            'gsm' => 'required_without:telefoon',
            'email' => 'email',
            'rubriek' => 'required',
            'vraag' => 'required',                  
        ])->validate();
        
        $contactpersoon = Contactpersoon::create([
            'voornaam' => $data['voornaam'],
            'familienaam' =>  $data['familienaam'],
            'relatie' =>  $data['relatie'],
            'straat' =>  $data['straat'],
            'huisnummer' =>  $data['huisnummer'],
            'bus' =>  $data['bus'],
            'postcode' => $data['postcode'],
            'gemeente' => $data['gemeente'],
            'telefoon' => $data['telefoon'],
            'gsm' => $data['gsm'],
            'email' => $data['email'],
            'rubriek' =>  $data['rubriek'],
            'vraag' =>  $data['vraag'],    
            'openstaand' => 1,             
        ]);
        
        session()->flash('bericht', 'De gegevens werden verstuurd. We nemen binnenkort contact op');  
        $this->mail('sociaal@devleugels.be', $contactpersoon);
        $this->mail($contactpersoon['email'], $contactpersoon); 
        return ['message' => "contactpersonen"];
    }
 
    public function mail($email,$contactpersoon){
      Mail::to($email)->send( new ContactpersoonMail($contactpersoon));
    }
   
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Contactpersoon  $contactpersoon
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contactpersoon = Contactpersoon::findOrFail($id);
        return view('contactpersoon.show', compact('contactpersoon'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contactpersoon  $contactpersoon
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = DB::table('contactpersoons')->find($id);
        
        
        $vraag = array(
            'id' => $id,
            'voornaam' => $data->voornaam,
            'familienaam' => $data->familienaam,
            'relatie' => $data->relatie,
            'straat' => $data->straat,
            'huisnummer' => $data->huisnummer,
            'bus' => $data->bus,
            'postcode' =>$data->postcode,
            'gemeente' =>$data->gemeente,
            'telefoon' =>$data->telefoon,
            'gsm' =>$data->gsm,
            'email' =>$data->email,
            'rubriek' => $data->rubriek,
            'vraag' => $data->vraag,    
            'openstaand' => 1,            
          );
          $vraag = json_encode($vraag);
        return view('contactpersoon.edit', compact('vraag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contactpersoon  $contactpersoon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
         $data = [
            'voornaam' => $request->data['voornaam'],
            'familienaam' => $request->data['familienaam'],
            'relatie' => $request->data['relatie'],
            'straat' => $request->data['straat'],
            'huisnummer' => $request->data['huisnummer'],
            'bus' => $request->data['bus'],
            'postcode' =>$request->data['postcode'],
            'gemeente' =>$request->data['gemeente'],
            'telefoon' =>$request->data['telefoon'],
            'gsm' =>$request->data['gsm'],
            'email' =>$request->data['email'],
            'rubriek' => $request->data['rubriek'],
            'vraag' => $request->data['vraag'], 
            'openstaand' => $request->data['openstaand'],            
        ];
        
        $validator = Validator::make($data, [
            'voornaam' => 'required | min:2',
            'familienaam' => ' required | min:2',
            'relatie' => 'required | min:2',
            'straat' => ' required | min:2',
            'huisnummer' => ' required',
            'postcode' => 'required',
            'gemeente' => 'required',
            'telefoon' => 'required_without:gsm',
            'gsm' => 'required_without:telefoon',
            'email' => 'email',
            'rubriek' => 'required',
            'vraag' => 'required',   
        ])->validate();
      
        
        $contactpersoon = Contactpersoon::findOrFail($id);
        $contactpersoon->update($data);
        
    //    return redirect()->action('ContactpersoonController@index');
       
        return ['message' => 'contactpersonen'];       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contactpersoon  $contactpersoon
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Contactpersoon::destroy($id);
        return redirect()->action('ContactpersoonController@index');        //
    }
}
