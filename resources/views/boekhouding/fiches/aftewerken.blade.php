@php
/**
 * toon nu alle aanvragen
 */
 $info = json_decode($info);
 $aftewerken = [];
 
 $hotels = $info->hotel;
 // dd($hotels);
 if ($hotels != null){
    $fulltype = \App\Enums\ServiceType::getValue('hotel');
    foreach($hotels as $hotel){
	  $factuur = DB::table('factuurs')
                  ->where([
                    ['serviceable_id', $hotel->id],
                    ['serviceable_type', $fulltype]
                  ])->first();	
//      dd($factuur);
      if ($hotel->bedrag == 0 or $factuur->factuurvolgnummer == null){
            $temp['type'] = 'hotel';
            $temp['info'] = $hotel;
			$temp['factuur'] = $factuur;
            $aftewerken[] = $temp;      
      }
    }
 }
 $dagverblijven = $info->dagverblijf;
 if ($dagverblijven != null){
    dd('[boekhouding.fiches.aftewerken] TODO');
 }
 $therapies = $info->therapie;
 if ($therapies != null){
    dd('[boekhouding.fiches.aftewerken] TODO');
 }
 // dd($aftewerken);
 

@endphp

<div class="tab-pane fade show" id="pills-aftewerken" role="tabpanel" aria-labelledby="pills-aftewerken-tab">
   <div class="card" style="width : 100%">
     <div class="card-body">
       <h5 class="card-title d-flex justify-content-center">aftewerken</h5>
       <h6 class="card-subtitle d-flex justify-content-center">deze diensten moeten nog verwerkt worden</h6>
         
       @if (empty($aftewerken))
          <p class="d-flex justify-content-center">Er zijn geen af te werken facturen </p>
       @else
          <table class="table table-striped" >
             <thead>
                <tr>
                   <td>type</td>
                   <td>status</td>
                   <td>klant</td>
                   <td>omschrijving</td>
                   <td></td>
                </tr>
             </thead>
             <tbody>
             @foreach ($aftewerken as $item)
               @php
               $type = $item['type'];
               $id = $item['info']->id;
               $status = $item['info']->status;
               $fulltype = \App\Enums\ServiceType::getValue($type);
               $client_id = DB::table('serviceables')
                  ->where([
                    ['serviceable_id', $item['info']->id],
                    ['serviceable_type', $fulltype]
                  ])->first()->client_id;
               $client = \App\Client::findOrFail($client_id);
               $klantnaam = $client->voornaam." ".$client->familienaam;
               $omschrijving =  \App\Helper::getServiceOmschrijving( $id, $fulltype);
               @endphp
               <tr>
                  <td>{{ $type }}</td>
                  <td>{{ $status }}</td>
                  <td>{{ $klantnaam }}</td>
                  <td>{{ $omschrijving }}</td>
                  <td>
                     <a class="btn btn-primary" href="/boekhouding/{{ $id }}/{{ $type }}/detail">detail</a>
                   </td>
               </tr>
             @endforeach   
             </tbody>
          </table>
       @endif
     </div>
   </div>
</div>
