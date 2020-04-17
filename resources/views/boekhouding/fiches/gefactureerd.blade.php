@php
/**
 * toon nu alle aanvragen
 */
 $info = json_decode($info);
 $gefactureerd = [];
 
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
      if ($hotel->bedrag > 0 and $factuur->factuurvolgnummer != null){
            $temp['type'] = 'hotel';
            $temp['info'] = $hotel;
			$temp['factuur'] = $factuur;
            $gefactureerd[] = $temp;      
      }
    }
 }
 $dagverblijven = $info->dagverblijf;
 if ($dagverblijven != null){
    dd('[boekhouding.fiches.gefactureerd] TODO');
 }
 $therapies = $info->therapie;
 if ($therapies != null){
    dd('[boekhouding.fiches.gefactureerd] TODO');
 }
 // dd($gefactureerd);
 

@endphp

<div class="tab-pane fade show" id="pills-gefactureerd" role="tabpanel" aria-labelledby="pills-gefactureerd-tab">
   <div class="card" style="width : 100%">
     <div class="card-body">
       <h5 class="card-title d-flex justify-content-center">gefactureerd</h5>
       <h6 class="card-subtitle d-flex justify-content-center">deze diensten moeten nog verwerkt worden</h6>
         
       @if (empty($gefactureerd))
          <p class="d-flex justify-content-center">Er zijn geen facturen </p>
       @else
          <table class="table table-striped" >
             <thead>
                <tr>
                   <td>type</td>
                   <td>status</td>
			      	 <td>betaald</td>
                   <td>klant</td>
                   <td>omschrijving</td>
                   <td></td>
                </tr>
             </thead>
             <tbody>
             @foreach ($gefactureerd as $item)
               @php
               $type = $item['type'];
               $id = $item['info']->id;
               $status = $item['info']->status;
			   if ( $item['factuur']->betaald )
			   		$betaald = "ja";
			   else
			        $betaald = "neen";
			   
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
				  <td>{{ $betaald }}</td>
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
