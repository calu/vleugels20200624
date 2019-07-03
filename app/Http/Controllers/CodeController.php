<?php

namespace App\Http\Controllers;

use App\Code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Enums\StatuutType;
use App\Enums\ActiviteitType;

class CodeController extends Controller
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
        
        $codes = DB::table('codes')->get();
        $codes = $this->convert_codedigit_to_text($codes);
        return view('codes.index', compact('codes'));
    }
    
    /**
     * hulpfunctie voor het omzetten van de codes in leesbare tekst
     *
     */
    public function convert_codedigit_to_text($codes)
    {
        $ret = array();
        foreach($codes as $code)
        {
            
            $code->statuut = StatuutType::getDescription($code->statuut);
            $code->activiteit = ActiviteitType::getDescription($code->activiteit);
            $ret[] = $code;
        }
        return $ret;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);

        $codes = array(
            'id' => 0,
            'statuut' => '',
            'activiteit' => '',
            'prijs' => '',        
          );
        $codes = json_encode($codes);
        return view('codes.create', compact('codes'));
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
 //       dd($data);

        $validator = Validator::make( $data, [
            'statuut' => 'required | min : 2',
            'activiteit' => 'required | min : 2',
            'prijs' => 'required | numeric'
         ])->validate();
        
        $code = Code::create([
            'statuut' => $data['statuut'],
            'activiteit' => $data['activiteit'],
            'prijs' => $data['prijs']
        ]);
        
        session()->flash('bericht', 'De gegevens werden verstuurd. We nemen binnenkort contact op');  
         return ['message' => "codes"];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Code  $code
     * @return \Illuminate\Http\Response
     */
    public function show(Code $code)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Code  $code
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = DB::table('codes')->find($id);
        
        
        $codes = array(
            'id' => $id,
            'statuut' => StatuutType::getDescription($data->statuut),
            'activiteit' => ActiviteitType::getDescription($data->activiteit),
            'prijs' => $data->prijs
          );
          $codes = json_encode($codes);
        return view('codes.edit', compact('codes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Code  $code
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $data = [
            'prijs' => $request->data['prijs'],
        ];
        
        $validator = Validator::make($data, [
            'prijs' => 'required | numeric',
        ])->validate();
      
        
        $code = Code::findOrFail($id);
        $code->update($data);
        
    //    return redirect()->action('ContactpersoonController@index');
       
        return ['message' => 'codes'];    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Code  $code
     * @return \Illuminate\Http\Response
     */
    public function destroy(Code $code)
    {
        //
    }
}
