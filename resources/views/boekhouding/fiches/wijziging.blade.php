@php
/**
 * toon nu alle aanvragen
 */
 $info = json_decode($info);
 $wijziging = [];
 
 $hotels = $info->hotel;
 $arr =  ['wijzigingaanvraag', 'annulatieaanvraag'];
 if ($hotels != null){
    foreach($hotels as $hotel){
      if (in_array($hotel->status, $arr )){
            $temp['type'] = 'hotel';
            $temp['info'] = $hotel;
            $wijziging[] = $temp;      
      }
    }
 }
 $dagverblijven = $info->dagverblijf;
 if ($dagverblijven != null){
    dd('[boekhouding.fiches.wijziging] TODO');
 }
 $therapies = $info->therapie;
 if ($therapies != null){
    dd('[boekhouding.fiches.wijziging] TODO');
 }
 // dd($wijziging);
 

@endphp

<div class="tab-pane fade show" id="pills-wijziging" role="tabpanel" aria-labelledby="pills-wijziging-tab">
   <div class="card" style="width : 100%">
     <div class="card-body">
       <h5 class="card-title d-flex justify-content-center">wijziging / annulatie</h5>
       <h6 class="card-subtitle d-flex justify-content-center">deze diensten moeten nog verwerkt worden</h6>
         
       @if (empty($wijziging))
          <p class="d-flex justify-content-center">Er zijn geen wijzigingen </p>
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
             @foreach ($wijziging as $item)
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
