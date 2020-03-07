<?php

namespace App\Http\Controllers;

use App\Vragentype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class VragentypeController extends Controller
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
        
        $vragentype = DB::table('vragentypes')->paginate(10);
        return view('vragentype.index', compact('vragentype'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);

        $vragentype = array(
            'id' => 0,
            'vraagtype' => ''        
          );
          $vragentype = json_encode($vragentype);
        return view('vragentype.create', compact('vragentype'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);

        $thisRequest = request()->all();
        $data = $thisRequest['data'];

        $validator = Validator::make( $data, [
            'vraagtype' => 'required | min:2',
         ])->validate();
        
        $vragentype = Vragentype::create([
            'vraagtype' => $data['vraagtype'],
        ]);
        
  //      session()->flash('bericht', 'De gegevens werden verstuurd. We nemen binnenkort contact op');  
         return ['message' => "vragentype"];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vragentype  $vragentype
     * @return \Illuminate\Http\Response
     */
    public function show(Vragentype $vragentype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vragentype  $vragentype
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = DB::table('vragentypes')->find($id); 
        
        
        $vraagtype = array(
            'id' => $id,
            'vraagtype' => $data->vraagtype,
          );
          $vragentype = json_encode($vraagtype);
        return view('vragentype.edit', compact('vragentype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vragentype  $vragentype
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $data = [
            'vraagtype' => $request->data['vraagtype'],
        ];
        
        $validator = Validator::make($data, [
            'vraagtype' => 'required | min:2',
        ])->validate();
      
        
        $vragentype = Vragentype::findOrFail($id);
        $vragentype->update($data);
        
    //    return redirect()->action('ContactpersoonController@index');
       
        return ['message' => 'vragentype'];       

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vragentype  $vragentype
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vragentype $vragentype)
    {
        //
    }
}
