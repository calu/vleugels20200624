@php
/**
 * toon nu alle aanvragen
 */
 $info = json_decode($info);
 $goedgekeurd = [];
 
 $hotels = $info->hotel;
 if ($hotels != null){
    foreach($hotels as $hotel){
      if ($hotel->status != 'aangevraagd'){
            $temp['type'] = 'hotel';
            $temp['info'] = $hotel;
            $goedgekeurd[] = $temp;      
      }
    }
 }
 $dagverblijven = $info->dagverblijf;
 if ($dagverblijven != null){
    dd('[boekhouding.fiches.goedgekeurd] TODO');
 }
 $therapies = $info->therapie;
 if ($therapies != null){
    dd('[boekhouding.fiches.goedgekeurd] TODO');
 }
 // dd($goedgekeurd);
 

@endphp

<div class="tab-pane fade show" id="pills-goedgekeurd" role="tabpanel" aria-labelledby="pills-goedgekeurd-tab">
   <div class="card" style="width : 100%">
     <div class="card-body">
       <h5 class="card-title d-flex justify-content-center">goedgekeurde diensten</h5>
       <h6 class="card-subtitle d-flex justify-content-center">deze diensten moeten nog verwerkt worden</h6>
         
       @if (empty($goedgekeurd))
          <p class="d-flex justify-content-center">Er zijn geen goedgekeurde diensten</p>
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
             @foreach ($goedgekeurd as $item)
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
