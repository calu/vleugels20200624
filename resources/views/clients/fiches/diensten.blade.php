<?php
  
 /** haal de koppels <serviceable_id, serviceable_type> op voor deze client_id **/
 $koppels = DB::table('serviceables')->where('client_id', $client->id)->get();
 // dd($koppels);
 $hotelsitems = [];
 $kamerids = [];
 
 if (!empty($koppels)){
   foreach ($koppels as $item){
     switch ($item->serviceable_type){
       case 'App\Hotel':
          $hotel = DB::table('hotels')->where('id', $item->serviceable_id)->get()->first();
          $hotelitem = [];
          $hotelitem['hotel_id'] = $hotel->id;
          $hotelitem['begindatum'] = $hotel->begindatum;
          $hotelitem['einddatum'] = $hotel->einddatum;
          $hotelitem['kamer_id'] = $hotel->kamer_id;
          $kamerids[] = $hotel->kamer_id;
          $hotelitem['status'] = $hotel->status;
          $hotelitem['bedrag'] = $hotel->bedrag;
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
   
   // verwijder alle dubbele kamers
   $kamerunique = array_unique($kamerids);
   // haal nu alle kamergegevens die staan in kamarunique
   $kamers = [];
   foreach ($kamerunique as $id){
     $kamer = DB::table('kamers')->where('id', $id)->get()->first();
     $kamers[] = $kamer;
   }
 }
 ?>

<section class="resume-section col-12" id="diensten">    
  <div class="card">
     <h2 class="card-title text-primary text-center">Overzicht van alle diensten</h2>
     <!-- diensten @completed="vermelden" ></diensten -->
     
     <div class="resume-item d-flex flex-column flex-md-row mb-5"> 
        <div class="resume-content mr-auto ml-2">

          <div class="subheading mb-3">&nbsp;Overnachtingen</div>
            @if ( empty($hotelitems))
              <div class="content-align-center">Geen overnachtingen</div>
            @else
            <table class="table table-striped">
              <thead>
                <tr>
                  <td>#</td>
                  <td>status</td>
                  <td>begindatum</td>
                  <td>einddatum</td>
                  <td>kamer</td>
                  <td>bedrag</td>
                  <td></td>
                </tr>
              </thead>
              <tbody>
                @foreach ($hotelitems as $hotelit)
                  <tr>
                    <th scope="row">{{ $hotelit['hotel_id'] }}</th>
                    <td>{{ $hotelit['status']}}</td>
                    <td>{{ $hotelit['begindatum']}}</td>
                    <td>{{ $hotelit['einddatum']}}</td>
                    <td>
                      <a class="btn btn-primary" href="/kamers/{{ $hotelit['kamer_id']}}">toon detail</a>
                      
                    </td>
                    <td>{{ $hotelit['bedrag']}}</td>
                    <td><a href="/hotelreservatie/{{ $hotelit['hotel_id']}}/wijzig" class="btn btn-primary">wijzig of annuleer</td></td>
                  </tr>
                @endforeach
            </table>    
            @endif
          <div class="subheading mb-3">&nbsp;Dagverblijf</div>
            <p>TODO</p>
          
          <div class="subheading mb-3">&nbsp;Therapie</div>
            <p>TODO</p>       
                                                           
        </div>
        <div class="resume-content mr-auto">
          keuze?
        </div>      
     </div>
  </div>
</section>