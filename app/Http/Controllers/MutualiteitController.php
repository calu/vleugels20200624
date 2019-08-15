<?php

namespace App\Http\Controllers;

use App\Mutualiteit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class MutualiteitController extends Controller
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
        
        $mutualiteiten = DB::table('mutualiteits')->paginate(10);
        return view('mutualiteiten.index', compact('mutualiteiten'));
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);

        $mutualiteiten = array(
            'id' => 0,
            'naam' => ''        
          );
          $mutualiteiten = json_encode($mutualiteiten);
        return view('mutualiteiten.create', compact('mutualiteiten'));
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
            'naam' => 'required | min:2',
         ])->validate();
        
        $mutualiteit = Mutualiteit::create([
            'naam' => $data['naam'],
        ]);
        
        session()->flash('bericht', 'De gegevens werden verstuurd. We nemen binnenkort contact op');  
         return ['message' => "mutualiteiten"];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mutualiteit  $mutualiteit
     * @return \Illuminate\Http\Response
     */
    public function show(Mutualiteit $mutualiteit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mutualiteit  $mutualiteit
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = DB::table('mutualiteits')->find($id);
        
        
        $mutualiteiten = array(
            'id' => $id,
            'naam' => $data->naam,
          );
          $mutualiteiten = json_encode($mutualiteiten);
        return view('mutualiteiten.edit', compact('mutualiteiten'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mutualiteit  $mutualiteit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $data = [
            'naam' => $request->data['naam'],
        ];
        
        $validator = Validator::make($data, [
            'naam' => 'required | min:2',
        ])->validate();
      
        
        $mutualiteit = Mutualiteit::findOrFail($id);
        $mutualiteit->update($data);
        
    //    return redirect()->action('ContactpersoonController@index');
       
        return ['message' => 'mutualiteiten'];       

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mutualiteit  $mutualiteit
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Mutualiteit::destroy($id);
        return redirect()->action('MutualiteitController@index');        //
    }
}
