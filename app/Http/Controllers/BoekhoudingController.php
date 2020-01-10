<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Serviceable;
use App\Client;
use App\Hotel;
use App\Mutualiteit;
use App\Contactpersoon;
use App\Algemeen;
use DateTime;
use PDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\FactuurMail;

class BoekhoudingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /** hier komt alles voor de boekhouding uit te voeren **/
    public function index()
    {
        abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);
        
        // Haal alle serviceables
        $services = DB::table('serviceables')->paginate(10);
        
        return view('boekhouding.index', compact('services'));
    }
    
    /** functie detail geeft de details weer van deze service **/
    public function detail($id, $type)
    {
        abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);
        
        // haal de klant voor deze service
        $servicetype = \App\Enums\ServiceType::getValue($type);
        // dd($servicetype);
        $service = DB::table('serviceables')->where([['serviceable_id', $id], ['serviceable_type', $servicetype]])->first();
        $client_id = $service->client_id;
        // Haal nu de gegevens van deze klant
        $client = Client::where('id', $client_id)->first();
        $mutualiteit = DB::table('mutualiteits')->where('id', $client->mutualiteit_id)->first()->naam;
        $info = [];  
        $info['mutualiteit'] = $mutualiteit; 
        $info['statuut'] = \App\Enums\StatuutType::getDescription($client->statuur);
         
        $contactpersoon_id = $client->contactpersoon_id;
        $contactpersoon = DB::table('contactpersoons')->where('id', $contactpersoon_id)->first();
        $info['contact_voornaam'] = $contactpersoon->voornaam;
        $info['contact_familienaam'] = $contactpersoon->familienaam;
        $info['contact_relatie'] = $contactpersoon->relatie;
        $info['contact_straat'] = $contactpersoon->straat;
        $info['contact_huisnummer'] = $contactpersoon->huisnummer;
        $info['contact_bus'] = $contactpersoon->bus;
        $info['contact_postcode'] = $contactpersoon->postcode;
        $info['contact_gemeente'] = $contactpersoon->gemeente;
        $info['contact_telefoon'] = $contactpersoon->telefoon;
        $info['contact_gsm'] = $contactpersoon->gsm;
        $info['contact_email'] = $contactpersoon->email;
       
       

        //dd($contactpersoon);
            
        switch ($type)
        {
            case 'hotel' :
                $this_service = DB::table('hotels')->where('id', $service->serviceable_id)->first();
                // dd($this_service);

                $info['hotel_id'] = $this_service->id;
                $info["begindatum"] = $this_service->begindatum;
                $info["einddatum"] = $this_service->einddatum;
                $info["status"] = $this_service->status;
                $info["bedrag"] = $this_service->bedrag;
                
                // haal de info van de kamer
                $this_kamer = DB::table('kamers')->where('id', $this_service->kamer_id)->first();
                // dd($this_kamer);
                $info["kamer_id"] = $this_kamer->id;
                $info["aantal_bedden"] = $this_kamer->aantal_bedden;
                $info["kamer_soort"] = $this_kamer->soort;
                $info["kamernummer"] = $this_kamer->kamernummer;
                $info["kamer_beschrijving"] = $this_kamer->beschrijving;
                $info["kamer_foto"] = $this_kamer->foto;
                
                // haal de klantgegevens op voor de factuur
//                dd($client->factuur_naam);
                $info["factuur_naam"] = $client->factuur_naam;
                $info["factuur_straat"] = $client->factuur_straat;
                $info["factuur_huisnummer"] = $client->factuur_huisnummer;
                $info["factuur_bus"] = $client->factuur_bus;
                $info["factuur_postcode"] = $client->factuur_postcode;
                $info["factuur_gemeente"] = $client->factuur_gemeente;
                $info["factuur_email"] = $client->factuur_email;
                
                
                $date1 = new \DateTime($this_service->begindatum);
                $date2 = new \DateTime($this_service->einddatum);
                $aantaldagen = $date2->diff( $date1 )->format('%a');

                $info["aantal_dagen"] = $aantaldagen;
                
                $info['factuurdatum'] = date('j-n-Y');
                $verval = new DateTime('NOW');
                $verval->modify('+1 month'); 
                $info['vervaldatum'] = date_format($verval, 'j-n-Y');
                $info['factuurnummer'] = 'A1234';
                $info['onzeref'] = 'AB111';
                $info['omschrijving'] = 'kamer van '.$info['begindatum'].' tot '.$info['einddatum'];
                $btw = 21;
                $info['btw'] = $btw;   
                $info['bedragzonder'] = $info['bedrag'] * (100 - $btw)/100 ;
            
                break;
            case 'therapie' :

                break;
            case 'dagverblijf' :

                break;
        }
        // Toon nu de info - args = client, service
        //dd($client->voornaam);
        
        
        return view('boekhouding.detail', compact( 'client', 'info'));
    }
    
    public function store()
    {
        abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);

        $thisRequest = request()->all();
        $data = $thisRequest['data'];
  //      dd($data);

        $validator = Validator::make( $data, [
            'bedrag' => 'required | numeric'
         ])->validate();
        
        DB::table('hotels')
            ->where('id', $data['hotel_id'])
            ->update(['bedrag' => $data['bedrag']]);

         $url = 'boekhouding/'.$data['hotel_id'].'/hotel/detail'; 
         return ['message' => $url];

    }
    
    public function factuur()
    {
         abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);

        $thisRequest = request()->all();
        $data = $thisRequest['data']; 
        
        $validator = Validator::make( $data, [
            'factuurnummer' => 'required',
            'factuurdatum' => 'required | date | after_or_equal:today',
            'vervaldatum' => 'required | date | after: factuurdatum',  // ook nog na factuurdatum
            'onzeref' => 'required',
            'bedragzonder' => 'required | numeric',
            'btw' => 'required | numeric',
            'bedrag' => 'required | numeric',
            'omschrijving' => 'required',
        ])->validate();
        

         $afzender = DB::table('algemeens')->find(1);     
                 
             
        $pdfdata = [
            'naam' =>$data['factuur_naam'],
            'straat' => $data['factuur_straat'],
            'huisnummer' => $data['factuur_huisnummer'],
            'bus' => $data['factuur_bus'],
            'postcode' => $data['factuur_postcode'],
            'gemeente' => $data['factuur_gemeente'],
            'factuurdatum' => $data['factuurdatum'],
            'vervaldatum' => $data['vervaldatum'],
            'factuurnummer' => $data['factuurnummer'],
            'onzeref' => $data['onzeref'],
            'omschrijving' => $data['omschrijving'],
            'bedrag1' => $data['bedragzonder'],
            'bedrag' => $data['bedrag'],
            'btw' => $data['btw'],
            
            'afzender_naam' => $afzender->factuur_afzendernaam,
            'afzender_straatennummer'=> $afzender->factuur_afzenderstraatennummer,
            'afzender_ZipenGemeente' => $afzender->factuur_afzenderZipenGemeente,
            'afzender_Telefoon' => $afzender->factuur_afzenderTelefoon,
            'factuur_afzenderEmail' => $afzender->factuur_afzenderEmail,
            'factuur_banknaam' => $afzender->banknaam,
            'factuur_iban' => $afzender->iban,
            'factuur_bic' => $afzender->bic
            
        ];
        
        $pdf = PDF::loadView('boekhouding.sjabloon', $pdfdata);
  
//        return $pdf->download('itsolutionstuff.pdf');
//        return $pdf->save('temp/testpdf.pdf')->stream('teststream.pdf');
        $pdf->save('temp/testpdf.pdf');
 //       $pdf->stream('vleugels.pdf');
        $naam = $data['contact_voornaam']." ".$data['contact_familienaam'];
      
        Mail::to('info@devleugels.be')->send( new FactuurMail($naam));        
        if (strlen($data['factuur_email']) > 0){
            $bericht = "Er werd een e-mail verstuurd naar de contactpersoon en naar de boekhouder";
            Mail::to($data['factuur_email'])->send(new FactuurMail($naam));
        } else {
            $bericht = "Er werd geen e-mail gestuurd naar de contactpersoon, omdat we geen e-mail adres hebben, wel naar de boekhouder";
        }
        // Mail::to('johan.calu@gmail.com')->send( new SendMailable($data['naam']));
        // en dan een return naar een goed pagina
        //return view('pdf/succes');

        session()->flash('bericht', $bericht);
        $url = 'boekhouding/verzonden';
        return ['message' => $url];
    }
    
    
    public function verzonden()
    {
         abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);
         
         return view('boekhouding.verzonden');     
    }
    
    public function update(Request $request, Client $client)
    {
        dd("update van boekhouding");
    }
    
    public function test(){

         $afzender = DB::table('algemeens')
            ->where('id',1)->get(); 
          dd($afzender);        
    }
}
