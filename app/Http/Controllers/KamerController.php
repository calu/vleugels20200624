<?php

namespace App\Http\Controllers;

use App\Kamer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\File;

class KamerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except' => 'visualindex']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);
        
        $kamers = DB::table('kamers')->paginate(10);
        return view('kamers.index',compact('kamers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
          $kamer =  array(
            'id' => 0, 
            'kamernummer' => '',
            'aantal_bedden' => '',
            'soort' => '',
            'beschrijving' => '',
            'foto' => '',
          ); 
          
          $kamer = json_encode($kamer);  
          return view('kamers.create', compact('kamer'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // merk op : niet getest
        $thisRequest = request()->all();
        $data = $thisRequest['data'];

        $validator = Validator::make( $data, [
            'kamernummer' => 'required | unique:kamers,kamernummer',
            'aantal_bedden' => ' required',
            'soort' => 'required',
            'beschrijving' => ' required',               
        ])->validate();
        
        $kamer = Kamer::create([
            'kamernummer' => $data['kamernummer'],
            'aantal_bedden' =>  $data['aantal_bedden'],
            'soort' =>  $data['soort'],
            'beschrijving' =>  $data['beschrijving'],
            'foto' =>  $data['foto'],           
        ]);
        
        return ['message' => "kamers"];

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Kamer  $kamer
     * @return \Illuminate\Http\Response
     */
    public function show(Kamer $kamer)
    {
        return view('kamers.show', compact('kamer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Kamer  $kamer
     * @return \Illuminate\Http\Response
     */
    public function edit(Kamer $kamer)
    {
        abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);
        
        return view('kamers.edit', compact('kamer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kamer  $kamer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = [
            'kamernummer' => $request->data['kamernummer'],
            'aantal_bedden' =>  $request->data['aantal_bedden'],
            'soort' =>  $request->data['soort'],
            'beschrijving' =>  $request->data['beschrijving'],
            'foto' =>  $request->data['foto'],           
        ];
        
        $validator = Validator::make( $data, [
            'kamernummer' => 'required',
            'aantal_bedden' => ' required',
            'soort' => 'required',
            'beschrijving' => ' required',               
        ])->validate();
        
        $kamer =  Kamer::findOrFail($id); 
        $kamer->update($data);     
        return ['message' => 'kamers'];      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kamer  $kamer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);

        $data = DB::table('kamers')->find($id);
        // dd($data->foto);
        
        // verwijder bestand met naam "$data->foto" uit de map img/hotelkamers
        $image_path = "img/hotelkamers/".$data->foto;
        if (File::exists($image_path)){
            File::delete($image_path);
        };
     
        Kamer::destroy($id);
        return redirect()->action('KamerController@index');            
    }
    
    public function visualindex()
    {
        $kamers = DB::table('kamers')->paginate(10);
        return view('kamers.visualindex', compact('kamers'));
    }
}
