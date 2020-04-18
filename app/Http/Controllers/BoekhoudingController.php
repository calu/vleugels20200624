<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Serviceable;
use App\Client;
use App\Hotel;
use App\Kamer;
use App\Mutualiteit;
use App\Contactpersoon;
use App\Algemeen;
use App\Helper;
use App\Factuur;
use DateTime;
use PDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\FactuurMail;
use App\Mail\FactuurNulMail;
use App\Enums\ServiceType;
use App\Enums\StatuutType;

class BoekhoudingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }
    
    /** hier komt alles voor de boekhouding uit te voeren **/
    public function index()
    {
      // enkel de admin mag dit bekijken
      abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);
      
     // $diensten = DB::table('serviceables')->paginate(10);
      
      // We onderzoeken per categorie ($hotels, $dagverblijf, $therapie)
      $info['hotel'] = DB::table('hotels')->get();
      $info['dagverblijf'] = null; // TODO
      $info['therapie'] = null; // TODO
      $info = json_encode($info);
      return view('boekhouding.index', compact('info')); 
      
    }
    /*
    public function index()
    {
        abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);
        
        // Haal alle serviceables
        $services = DB::table('serviceables')->paginate(10);

        return view('boekhouding.index', compact('services')); 
    }
    
    /**
     * function detail
     *   geeft alle details van deze service voor deze bepaalde klant en
     *   toont meteen ook alle andere services die voor deze klant
     *   nog open staan
     *
     */
    public function detail($id, $type)
    {
      // enkel voor admin
      abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);    
      
    // $test = "id = ".$id." en type = ".$type;
    // dd($test);
     
      // we zullen hier een factuur aanmaken en dus verzamelen 
      $servicetype = \App\Enums\ServiceType::getValue($type);
      $client = Helper::getClientFromServiceable($id, $servicetype);
      // voeg mutualiteiten en statuten toe aan de client
      $mutualiteiten = Mutualiteit::all();
      $statuten = StatuutType::getInstances();
      $info['mutualiteiten'] = $mutualiteiten;
      $info['statuten'] = $statuten;
     
      
      $info['client'] = $client;
      
      // haal nu alle details voor deze service
      $info['service'] = $this->getServiceInfo($id, $servicetype);
      // de mutualiteitgegevens ophalen
      $info['mutualiteit'] = Mutualiteit::where('id', $client->mutualiteit_id)->get()->first();
      // de contactpersoon
      $info['contactpersoon'] = Contactpersoon::where('id', $client->contactpersoon_id)->get()->first();

      // Het zou kunnen dat er reeds een factuur (of meerdere) bestaat voor deze
      // service. Dus moeten we nu eerst zoeken of het bestaat
      /* $test = "id = $id en type = $servicetype";
      dd($test); */
      $facturen = \App\Factuur::where([
            [ 'serviceable_id' , $id],
            [ 'serviceable_type', $servicetype ]
        ])->orderBy('datum', 'desc')->get();
      if ($facturen->isEmpty()){
         // maak nu een array met lege factuur
         $factuur['id'] = 0;
         $factuur['factuurvolgnummer'] = null; // pro forma
         $factuur['jaar'] = null; // pro forma
         $factuur['datum'] = $info['service']['factuurdatum']; // factuurdatum
         $factuur['serviceable_id'] = $info['service']['serviceable_id'];
         $factuur['serviceable_type'] = $info['service']['serviceable_type'];
         $factuur['omschrijving'] = $info['service']['omschrijving'];
         $factuur['aantal'] = $info['service']['aantaldagen'];
         $factuur['prijs'] = $info['service']['hotel']->bedrag;
         $factuur['betaald'] = false;
         $factuur['referentie'] = null; 
      }
      else
      {
        // Hier moeten we dus de bestaande factuur ophalen

        /*
        Het kan zijn dat er meerdere facturen zijn met dezelfde id,type
        Als dat zo is, dan tonen we hier enkel de laatste (datum = leidraad)
         */
        $factuur = $facturen->first();
        
      }
      $info['factuur'] = $factuur;
      
      $info['factuur']['mogelijknr'] = Helper::getFactuurnummer();
      $info['factuur']['mogelijkjaar'] = date('Y');
      
      return view('boekhouding.detail', compact('info'));
    }
    /*
    public function detail($id, $type) 
    {
        // enkel voor admin
        abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);    
        
        // haal het servicetype op
        $servicetype = \App\Enums\ServiceType::getValue($type);
        // haal de klant-id die hoort bij deze <id,servicetype>
        $client = $this->getClientFromServiceable($id, $servicetype);
       
       // We maken een array info aan
       $info = [];
       
       // De mutualiteit van deze klant
       $mutualiteit = DB::table('mutualiteits')->where('id', $client->mutualiteit_id)->first()->naam;
       $info['mutualiteit'] = $mutualiteit;
       $info['statuut'] = \App\Enums\StatuutType::getDescription($client->statuut);   
    
       $contactpersoon = DB::table('contactpersoons')->where('id', $client->contactpersoon_id)->first();    
       $info['contactpersoon'] = $contactpersoon;
       
       $info['client'] = $client;
       
       // nu zoeken we de gegevens voor deze service
       $info['this_service'] = $this->getServiceInfo($id, $type);
       
       return view('boekhouding.detail', compact('info'));
    }
    
    /** hulpfunctie : getClientFromServiceable($id,$type)
     *  met de serviceable_id en serviceable_type halen we de
     *  bijhorende klant
     */ /*
    public function getClientFromServiceable($id, $type)
    {
      try{
        $service = DB::table('serviceables')
                     ->where([
                       ['serviceable_id', $id],
                       ['serviceable_type', $type]
                     ])->first();
      } catch (Exception $e){
        dd("[BoekhoudingController@getClientFromServiceable] - geen overeenkomstige dienst ($id,$type)");
      }
      
      return Client::where('id', $service->client_id)->first();
    } */
   /*  
   public function getClientFromServiceable($id, $type)
   {
       try {
           $service = DB::table('serviceables')->where([['serviceable_id', $id], ['serviceable_type', $type]])->first();       
       } catch (Exception $e) {
           echo "[BoekhoudingController@getClientFromServiceable] TIJDELIJK - geen overeenkomstige dienst gevonden - verwittig admin";
       }
       // haal nu de klant die hoort bij deze entry
       $client_id = $service->client_id;
       
       // nu halen we alle data die nodig is voor deze service (en de andere services van deze klant die openstaan)
       // We beginnen met alle klantgegevens
       $client = Client::where('id', $client_id)->first();
       return $client;
   }    
    
    /**
     * function getServiceInfo
     * @arg :
     *   id = id van deze service
     *   type = gewone naam van service
     * hulpfunction voor detail
     */
    public function getServiceInfo($id, $type)
    {
      $data['serviceable_id'] = $id;
      $data['serviceable_type'] = $type;
      $servicetype = \App\Enums\ServiceType::getDescription($type);
      switch ($servicetype)
      {
        case 'hotel':
          $hotel = Hotel::findOrFail($id);
          $data['hotel'] = $hotel;
          try{
            $data['kamer'] = Kamer::findOrFail($hotel->kamer_id);
          } catch (Exception $e){
            $data['kamer'] = null; 
          }
          
          $date1 = new \DateTime($hotel->begindatum);
          $date2 = new \DateTime($hotel->einddatum);          
          $data['aantaldagen'] = $date2->diff($date1)->format('%a');
          $data['factuurdatum'] = date('Y-m-d');
          $verval = new DateTime('NOW');
          $verval->modify('+1 month'); 
          $data['vervaldatum'] = date_format($verval, 'Y-m-d'); 
          
          // maak een factuurnummer - de vorm is 2020/0001
          // dus huidig jaar en vervolgnummer 
          // Het zou interessant zijn als we dit in een functie plaatsen
          $data['factuurnummer'] = Helper::getFactuurnummer();
          $data['omschrijving'] = 'kamer van '.$hotel->begindatum." tot ".$hotel->einddatum;              

          break;
        case 'dagverblijf' :
           /* TODO */
           break;
        case 'therapie' :
           /* TODO */
           break;        
      }    
//      dd($data);
      return $data;
    }
    /* 
    public function getServiceInfo($id, $type)
    {
        $data['serviceable_id'] = $id;
        $data['serviceable_type'] = ServiceType::getValue($type);
        switch ($type)
        {
            case 'hotel' :
              $this_service = DB::table('hotels')->where('id', $id)->first();
              // dd($this_service);
              
              // om de factuur te kunnen samenstellen hebben we heel wat info nodig
              $data['hotel'] = Hotel::findOrFail($this_service->id);
              try{
                $data['kamer'] = Kamer::findOrFail($this_service->kamer_id);
              } catch (Exception $e){
                $data['kamer'] = null;
                echo "[BoekhoudingController@getServiceInfo] geen kamer gevonden - verwittig admin";
              }
              
              $date1 = new \DateTime($this_service->begindatum);
              $date2 = new \DateTime($this_service->einddatum);
              $aantaldagen = $date2->diff( $date1 )->format('%a');

              $data['aantal_dagen'] = $aantaldagen;    
              $data['factuurdatum'] = date('d-m-Y');
              $verval = new DateTime('NOW');
              $verval->modify('+1 month'); 
              $data['vervaldatum'] = date_format($verval, 'j-n-Y');
              
              // maak een factuurnummer - de vorm is 2020/0001
              // dus huidig jaar en vervolgnummer 
              // Het zou interessant zijn als we dit in een functie plaatsen
              $data['factuurnummer'] = Helper::getFactuurnummer();
              $data['omschrijving'] = 'kamer van '.$this_service->begindatum." tot ".$this_service->einddatum;              
              break;
            case 'dagverblijf' :
              /* TODO * /
              break;
            case 'therapie' :
              /* TODO * /
              break;
        }        
        return $data;
    }
    /** functie detail geeft de details weer van deze service ** /
    public function detail_oud($id, $type)
    {

        
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
        $info['statuut'] = \App\Enums\StatuutType::getDescription($client->statuut);
         
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
        
        // eerst valideren
        $validator = Validator::make( $data, [
          'factuurvolgnummer' => 'required | numeric',
          'jaar' => 'required | date_format : Y',
          'datum' => 'required | date',
          'prijs' => 'required | numeric'
        ])->validate();

       $client = $this->getClientFromServiceable($data['serviceable_id'], $data['serviceable_type']);
       $contactpersoon_id = $client->contactpersoon_id;
       $contactpersoon = DB::table('contactpersoons')->where('id', $contactpersoon_id)->first();

        // spaar alles in factuurs
        // maar eerst de "datum" formatteren
        $data['datum'] = date('Y-m-d',strtotime($data['datum']));
        Factuur::create($data);
        
        $naam = $contactpersoon->voornaam." ".$contactpersoon->familienaam;
        
        if ( $data['prijs'] == 0)
        {
          // We maken geen pdf aan, maar sturen naar de boekhouder een mail
          // met daarin de info over deze factuur en de melding dat er nog geen
          // bedrag is ingevuld.
          $info['data'] = $data;
          $info['client'] = $client;
//          session(['info' => $info]);
          Mail::to('info@devleugels.be')->send(new FactuurNulMail($info));
          // maak ook een bericht aan met deze melding
          $bericht = "We hebben een factuur opgeslagen, maar geen pdf. Dit komt omdat je nog geen bedrag hebt ingevuld";
        } else {
          // maak een factuur
          $pdf = $this->maakFactuur($data);
          $pdf->save('temp/testpdf.pdf');
          
          // mail de factuur naar info en contactpersoon
          
          Mail::to('info@devleugels.be')->send(new FactuurMail($naam));
          if (strlen($client->factuur_email) > 0){
            $bericht = "Er werd een e-mail verstuurd naar de contactpersoon (ook naar info)";
            Mail::to($client->factuur_email)->send(new FactuurMail($naam));
          } else {
            $bericht = "Er werd geen e-mail gestuurd naar de contactpersoon, omdat we geen e-mail adres hebben, wel naar info";
          }
  // session(['factuur_email' => $client->factuur_email]);
          // spaar de prijs in Hotel->bedrag
          //   we kennen de serviceable_id (en het is hotel)
          $hotel = Hotel::findOrFail($data['serviceable_id']);
          $hotel->bedrag = $data['prijs'];
          $hotel->status = 'goedgekeurd';
          $hotel->save();
        }
        // maak een flash
        session()->flash('bericht', $bericht); 
        
        $url = 'boekhouding/verzonden';
 //       $url = 'test';
        return ['message' => $url];
    }
    
    /*
     * maakFactuur
     *   maakt een pdf document met een factuur als resultaat
     *
     *   We hebben dus ook een aantal data nodig
     * /
    public function maakFactuur($data)
    {
      // enkel een admin mag een factuur maken
      abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);

      // We halen nu alle data op die we nodig hebben voor de factuur
      // NOTEER : dit is voor hotel alleen
      // 1. we zoeken de klant 
      //    check of serviceable_type == App\Hotel
      //    haal de client_id die hoort bij serviceable_id
      $client = $this->getClientFromServiceable($data['serviceable_id'], $data['serviceable_type']);
      $afzender = DB::table('algemeens')->find(1);  

      // en vullen er een array pdfdata mee
      $verval = date('Y-m-d',strtotime($data['datum'].' +1 month'));
      $factuurnummer = $data['jaar'].'/'.sprintf("%04d",$data['factuurvolgnummer']);
      
      $pdfdata = [
        'naam' => $client->factuur_naam,
        'straat' => $client->factuur_straat,
        'huisnummer' => $client->factuur_huisnummer,
        'bus' => $client->factuur_bus,
        'postcode' => $client->factuur_postcode,
        'gemeente' => $client->factuur_gemeente,
        'factuurdatum' => $data['datum'],
        'vervaldatum' => $verval, // date_format($verval, 'j-n-Y'),
        'factuurnummer' => $factuurnummer,
        'onzeref' => $factuurnummer,
        'omschrijving' => $data['omschrijving'],
        'bedrag' => $data['prijs'],   
        
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
      
      return $pdf;
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
    */ 
}
