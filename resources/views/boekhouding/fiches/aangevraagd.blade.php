@php
/**
 * toon nu alle aanvragen
 */
 $info = json_decode($info);
 $aangevraagd = [];
 
 $hotels = $info->hotel;
 if ($hotels != null){
    foreach($hotels as $hotel){
      if ($hotel->status == 'aangevraagd'){
            $temp['type'] = 'hotel';
            $temp['info'] = $hotel;
            $aangevraagd[] = $temp;      
      }
    }
 }
 $dagverblijven = $info->dagverblijf;
 if ($dagverblijven != null){
    dd('[boekhouding.fiches.aangevraagd] TODO');
 }
 $therapies = $info->therapie;
 if ($therapies != null){
    dd('[boekhouding.fiches.aangevraagd] TODO');
 }
 // dd($aangevraagd);
 

@endphp

<div class="tab-pane fade show active" id="pills-aangevraagd" role="tabpanel" aria-labelledby="pills-aangevraagd-tab">
   <div class="card" style="width : 100%">
     <div class="card-body">
       <h5 class="card-title d-flex justify-content-center">Aangevraagde diensten</h5>
       <h6 class="card-subtitle d-flex justify-content-center">deze diensten moeten nog verwerkt worden</h6>
         
       @if (empty($aangevraagd))
          <p class="d-flex justify-content-center">Er zijn geen aangevraagde diensten</p>
       @else
          <table class="table table-striped" >
             <thead>
                <tr>
                   <td>type</td>
                   <td>klant</td>
                   <td>omschrijving</td>
                   <td></td>
                </tr>
             </thead>
             <tbody>
             @foreach ($aangevraagd as $item)
               @php
               $type = $item['type'];
               $id = $item['info']->id;
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
