<?php

namespace App\Http\Controllers;

use App\Algemeen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;


class AlgemeenController extends Controller
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
            
      $algemeen = DB::table('algemeens')
         ->where('id',1)->get()->first();
            
      return view('algemeen.index', compact('algemeen')); 
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
        abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);

        $thisRequest = request()->all();
        $data = $thisRequest['data'];

        $validator = Validator::make( $data, [
            'banknaam' => 'required | min : 2',
            'iban' => [ 'required',
                function( $attribute, $value, $fail)
                {
                    $match = preg_match('/^[A-Z]{2}[0-9]{2}[A-Z0-9]{1,30}$/', $value);
                    if (!$match) $fail($attribute, "is verkeerd");                      
                },
            ],
            'bic' => 'required | regex : "/[A-Z]{6}/"',
            'factuur_afzendernaam' => 'required | min:2',
            'factuur_afzenderstraatennummer' => 'required | min:2',
            'factuur_afzenderZipenGemeente' => 'required | min:2',
            'factuur_afzenderTelefoon' => 'required | min:2',
            'factuur_afzenderEmail' => 'required | email:rfc,dns',
            'sysadmin_email' => 'required | email:rfc,dns',
            
         ])->validate();  
      
         $algemeen = Algemeen::find(1);
         
         $algemeen->banknaam = $data['banknaam'];
         $algemeen->iban = $data['iban'];
         $algemeen->bic = $data['bic'];
         $algemeen->factuur_afzendernaam = $data['factuur_afzendernaam'];
         $algemeen->factuur_afzenderstraatennummer = $data['factuur_afzenderstraatennummer'];
         $algemeen->factuur_afzenderZipenGemeente = $data['factuur_afzenderZipenGemeente'];
         $algemeen->factuur_afzenderTelefoon = $data['factuur_afzenderTelefoon'];
         $algemeen->factuur_afzenderEmail = $data['factuur_afzenderEmail'];
         $algemeen->sysadmin_email = $data['sysadmin_email'];

         $algemeen->save();
         
        $url = 'algemeen/ok';
        return [ 'message' => $url];
    }
    
    public function ok()
    {
        abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);        
        return view('algemeen.ok');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Algemeen  $algemeen
     * @return \Illuminate\Http\Response
     */
    public function show(Algemeen $algemeen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Algemeen  $algemeen
     * @return \Illuminate\Http\Response
     */
    public function edit(Algemeen $algemeen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Algemeen  $algemeen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Algemeen $algemeen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Algemeen  $algemeen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Algemeen $algemeen)
    {
        //
    }
    
    /**
     * Wachtwoord vergeten wordt hier uitgevoerd
     *
     */
    public function vergeten()
    {
        return view('wachtwoord.vergeten');
    }
}
