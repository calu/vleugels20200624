@php
 /** haal de koppels <serviceable_id, serviceable_type> op voor deze client_id **/
 $koppels = DB::table('serviceables')->where('client_id', $client->id)->get();
 
 /** voor elk koppel halen we voor de 3 activiteiten info op en plaatsen in 3 array's **/
 $hotelitems = [];
 $dagitems = [];
 $therapieitems = [];
 
 foreach ($koppels as $item){
   switch ($item->serviceable_type){
     case 'App\Hotel':
        $hotel = DB::table('hotels')->where('id', $item->serviceable_id)->get()->first();
        $hotelitem = [];
        $hotelitem['hotel_id'] = $hotel->id;
        $hotelitem['begindatum'] = $hotel->begindatum;
        $hotelitem['einddatum'] = $hotel->einddatum;
        $hotelitem['kamer_id'] = $hotel->kamer_id;
        $kamernummer = DB::table('kamers')->where('id', $hotel->kamer_id)->get()->first()->kamernummer;
        $hotelitem['kamernummer'] = $kamernummer;
        $hotelitem['status'] = $hotel->status;
        $hotelitem['bedrag'] = $hotel->bedrag;
        $hotelitem['hotelchoice'] = false;
        if ($hotel->status == 'aangevraagd')
           $hotelitems[] = $hotelitem;
        break;
     case 'App\Dagverblijf':
        dd("clients.fiches.diensten : Dagverblijf nog in te vullen");
        break;
     case 'App\Therapie' :
        dd("clients.fiches.diensten : Therapie nog in te vullen");
        break;
   }
 }
 
$info['hotels'] = $hotelitems;
$info['dagverblijf'] = $dagitems; 
$info['therapie'] = $therapieitems;
$info['client_id'] = $client->id;

// dd($info);
@endphp

<section class="resume-section col-12" id="factuur">    
  <div class="card">
     <h2 class="card-title text-primary text-center">De facturen</h2>
       <ul class="list-group list-group-flush">
         <li class="list-group-item">
            @include('clients.fiches.pdffacturen')
         </li>
         @if (\Auth::User()->isAdmin())
         <li class="list-group-item">
           <factuur @completed="vermelden" 
              :data = "{{ json_encode($info)}}"></factuur>
         </li>
         @endif
       </ul>
  </div>
</section>