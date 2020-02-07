<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\WachtwoordVergetenMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class WachtwoordController extends Controller
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
        $data = $request->all();
        
        $validator = Validator::make( $data, [
            'email' => 'required | email : rfc, dns',
         ])->validate();        
         
       // dd($data['token']); 
        $email = $data['email'];
        $sys_admin = DB::table('algemeens')->first()->sysadmin_email;
       
        // We zoeken nu de contactpersoon die hoort bij deze klant
        // Stap 1 : haal de "User" met e-mail adres
        $user = DB::table('users')->where('email', $email)->get();
 //       dd($user);
        // Als we die gevonden hebben
        if (!$user->isEmpty())
        {
            // Stap 2 : haal de id van deze user
            $id = $user->first()->id;
           // dd($user->first());
            // Stap 3 : haal de client data voor deze id
            $klant = DB::table('clients')->where('user_id', $id);
            // dd($klant->first());
            $contactpersoon_id = $klant->first()->contactpersoon_id;
            // dd($contactpersoon_id);
            // Stap 4 : haal het e-mail adres van de contactpersoon
            $contactpersoon = DB::table('contactpersoons')->where('id', $contactpersoon_id)->first();
            $contactpersoon_email = $contactpersoon->email;            
            // dd($contactpersoon_email);
            //    sturen we een mail naar de contactpersoon en naar system_admin 
            $data = [null,$email];    
            
            $data = [];
            $data['voornaam'] = $contactpersoon->voornaam;
            $data['familienaam'] = $contactpersoon->familienaam;
            $data['email'] = $email;
            $data['gevonden'] = true;
            
            // We maken nu ook een token om aan te melden
            $token = Str::random(60);
            $hashed = hash('sha256', $token);
            $data['token'] = $token;
            DB::table('password_resets')->insert(
                [
                    'email' => $email,
                    'token' => $hashed,
                    'created_at' => new \DateTime()
                ]
            );
            
            
            $this->mail($contactpersoon_email, $data);    
            $this->mail($sys_admin, $data);
        } else
        {
            $data = [];
            $data['gevonden'] = false;
            $data['email'] = $email;
            $this->mail($sys_admin,$data);
        // Anders
        //    stuur een mail naar de system_admin            
        }
        
        $message = "een e-mail werd verstuurd met een link om een nieuw wachtwoord in te stellen";
        session()->flash('bericht', $message);  
        
        return view('welcome');
        // return view('wachtwoord.antwoord');
    }
    
 
    public function mail($email,$data){
      Mail::to($email)->send( new WachtwoordvergetenMail($data));
    }    
    
    public function reset($token)
    {
        // dd($token);
        $hashed = hash('sha256', $token);

        $row = DB::table('password_resets')->where('token', $hashed)->get()->first();
        if ($row == null){
            $message = "een fout gebeurde! Neem contact met de beheerder";
            dd($message);
        }
        $client_email = $row->email;
        
        $user = DB::table('users')->where('email', $client_email)->get()->first();
 //       dd($user->id);
        
        $data = [];
        $data['email'] = $client_email;
        $data['user_id'] = $user->id;
        $data['token'] = $token;
        
//        return view('auth/passwords/reset', [ 'token' => $token, 'email' => $client_email ]);
        
        return view('wachtwoord/vernieuwen', compact('data'));
    }
    
    public function vernieuwen(Request $request)
    {
        $data = $request->all();
  //      dd($data);
        
        $validator = Validator::make($data,
            [
                'user_id' => 'required',
                'wachtwoord' => 'required',
                'wachtworodbis' => ' required | same:wachtwoord'
                
            ]
        );
        
        $hashed = hash('sha256', $data['token']);
        $row = DB::table('password_resets')->where('token', $hashed)->get()->first();

        // als hashed gelijk is aan de has in tabel password_resets
        if ( $row != NULL)
        {
            //   vervang het wachtwoord in user met user_id
            $crypted_password = bcrypt($data['wachtwoord']);
            DB::table('users')->where('id', $data['user_id'])->update(['password' => $crypted_password]);           
            //   verwijder de entry in password_resets
            DB::table('password_resets')->where('token', $hashed)->delete();
                       
        } else {
            Echo "Sorry, maar dit lukt me niet";
            dd("Stop");
        }
        
        $bericht = "Het wachtwoord is gewijzigd";
        session()->flash('bericht', $bericht);
        return view('welcome');

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
