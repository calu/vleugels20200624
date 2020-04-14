<?php

namespace App\Http\Controllers;

use App\Factuur;
use Illuminate\Http\Request;

use Validator;
use App\Hotel;
use App\Helper;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\FactuurMail;

class FactuurController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }
        
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * /
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * /
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
      // enkel de admin mag dit bekijken
      abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);

      $thisRequest = request()->all();
      $data = $thisRequest['data'];     
      
      session(['data' => $data]);
      
      // valideer
      $validator = Validator::make( $data, [
        'factuurvolgnummer' => ' nullable | numeric',
        'jaar' => ' nullable | date_format : Y',
        'datum' => 'required | date',
        'prijs' => 'required | numeric',
        'betaald' => 'required | boolean', 
      ])->validate();      
        
      /* spaar de gegevens in factuurs
      // als er al een dergelijke bestaat (id,type) --> wat dan?
      // moeten we deze ook in pdf plaatsen??
      // en wat mailen we naar de user en de boekhouder??
         ook status='goedgekeurd' in Hotel ....
      */
      
      // spaar de gegevens in factuurs
      Factuur::create($data); // er bestaat nog geen factuur entry
      // stel het veld status in Hotels van 'aangevraagd' naar 'goedgekeurd'
// OPGELET -- dit is voor een hotel service !!!!
      $hotel = Hotel::findOrFail($data['serviceable_id']);
      $hotel->bedrag = $data['prijs'];
      $hotel->status = 'goedgekeurd';
      $hotel->save();
      
      // we keren nu terug naar dezelfde pagina waar we van komen      
      $url = 'test';
      $servicetype = \App\Enums\ServiceType::getDescription($data['serviceable_type']);
      $url = "boekhouding/". $data['serviceable_id']."/".$servicetype."/detail";
      return  ['message' => $url];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Factuur  $factuur
     * @return \Illuminate\Http\Response
     * /
    public function show(Factuur $factuur)
    {
//        dd($factuur);
        return view('factuur.show', compact('factuur'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Factuur  $factuur
     * @return \Illuminate\Http\Response
     * /
    public function edit(Factuur $factuur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Factuur  $factuur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Factuur $factuur)
    {
      // enkel de admin mag dit bekijken
      abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);

      $thisRequest = request()->all();
      $data = $thisRequest['data'];     
      
      session(['data' => $data]);
      
      $url = 'test';
      return  ['message' => $url];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Factuur  $factuur
     * @return \Illuminate\Http\Response
     * /
    public function destroy(Factuur $factuur)
    {
        //
    }
    */
    
    /*
     * druk de volledige factuur af, zoals beschreven in de tabel factuurs
     *
     * @param \App\Factuur  $factuur->id
     * @return 
     *
     */
     public function drukFactuur(Request $request, $id)
     {
      // enkel de admin mag dit bekijken
      abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);

      $thisRequest = request()->all();
      
      $factuur_id = $thisRequest['factuur_id'];
      $stuurNaarKlant = $thisRequest['inlineRadioOptions']; // is 'ja' of 'neen'
      
      // Nu halen we alle gegevens op die we nodig hebben om de factuur te maken
      /* we starten met het zoeken naar het e-mail adres voor de klant */
      $factuur = Factuur::where('id', $factuur_id)->first();
      $client = Helper::getClientFromServiceable($factuur['serviceable_id'], $factuur['serviceable_type']);
      
      // We hebben de gegevens van de contactpersoon nodig voor voor- en familienaam en e-mail
      $cp = DB::table('contactpersoons')->where('id', $client->contactpersoon_id)->first();

      $pdfdata = $this->getFactuurData($factuur, $client);
      $pdf = PDF::loadView('boekhouding.sjabloon', $pdfdata);
      $pdf->save('temp/testpdf.pdf');
          
      // nu kunnen we de factuur verzenden
      $naam = $cp->voornaam.' '.$cp->familienaam;
      Mail::to($pdfdata['factuur_afzenderEmail'])->send(new FactuurMail($naam));
         
      if (strlen($client->factuur_email) == 0){
        // meld in de mail aan de boekhouder dat de contactpersoon geen e-mail adres heeft
        $bericht = "Er werd geen e-mail gestuurd naar de contactpersoon, omdat we geen e-mail hebben.";
      } else {
        if ($stuurNaarKlant == 'ja'){
          $bericht = "Er een e-mail gestuurd naar de contactpersoon en naar jou";                
          Mail::to($client->factuur_email)->send(new FactuurMail($naam));        
        } else {
          $bericht = "Er werd geen e-mail gestuurd naar de contactpersoon op uw vraag";
        }
      }
      
      session()->flash('bericht', $bericht); 
      // nu terug naar boven
      $servicetype = \App\Enums\ServiceType::getDescription($factuur->serviceable_type);
      $url = "boekhouding/". $factuur->serviceable_id."/".$servicetype."/detail";
 //     return redirect()->route($url);
      return back();
     }
     
     /*
      * We verzamelen alle data nodig om de factuur te kunnen samenstellen
      *
      *  @param : $factuur en $client
      *  @return : $pdfdata
      *
      */
      public function getFactuurData($factuur, $client)
      {
          // We beginnen bij de klant
          $pdfdata['naam'] = $client->factuur_naam;
          $pdfdata['straat'] = $client->factuur_straat;
          $pdfdata['huisnummer'] = $client->factuur_huisnummer;
          $pdfdata['bus'] = $client->factuur_bus;
          $pdfdata['postcode'] = $client->factuur_postcode;
          $pdfdata['gemeente'] = $client->factuur_gemeente;
          $pdfdata['factuurdatum'] = $factuur->datum;
          $verval = date('Y-m-d', strtotime($factuur->datum.' +1 month'));
          $pdfdata['vervaldatum'] = $verval;
          if ($factuur->factuurvolgnummer == null)
            $factuurnummer = "PRO FORMA";
          else
            $factuurnummer = $factuur->jaar."/".$factuur->factuurvolgnummer;
          $pdfdata['factuurnummer'] = $factuurnummer;
          $pdfdata['onzeref'] = $factuurnummer;
          $pdfdata['omschrijving'] =$factuur->omschrijving;
          $pdfdata['bedrag'] = $factuur->prijs;
          
          // nu nog de info van de vleugels zelf -- staat in algemeens
          $afzender = DB::table('algemeens')->find(1);  
          
          $pdfdata['afzender_naam'] = $afzender->factuur_afzendernaam;
          $pdfdata['afzender_straatennummer'] = $afzender->factuur_afzenderstraatennummer;
          $pdfdata['afzender_ZipenGemeente'] = $afzender->factuur_afzenderZipenGemeente;
          $pdfdata['afzender_Telefoon'] = $afzender->factuur_afzenderTelefoon;
          $pdfdata['factuur_afzenderEmail'] = $afzender->factuur_afzenderEmail;
          $pdfdata['factuur_banknaam'] =  $afzender->banknaam;
          $pdfdata['factuur_iban'] = $afzender->iban;          
          $pdfdata['factuur_bic'] = $afzender->bic;       
          return $pdfdata;
      }
}
