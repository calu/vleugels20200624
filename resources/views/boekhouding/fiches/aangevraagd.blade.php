@php
/**
 * de aangevraagde diensten zijn deze die in de serviceable zijn gedefinieerd 
 * en die we doorgeven in de controller als diensten
 */
// dd($diensten);
@endphp

<div class="tab-pane fade show active" id="pills-aangevraagd" role="tabpanel" aria-labelledby="pills-aangevraagd-tab">
   <div class="card" style="width : 100%">
     <div class="card-body">
       <h5 class="card-title d-flex justify-content-center">Aangevraagde diensten</h5>
       <h6 class="card-subtitle d-flex justify-content-center">deze diensten moeten nog verwerkt worden</h6>
         
       @if ($diensten->isEmpty())
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
             @foreach ($diensten as $dienst)
               @php
                 $type = \App\Enums\ServiceType::getDescription($dienst->serviceable_type);
                 $client = \App\Client::findOrFail($dienst->client_id);
                 $klantnaam = $client->voornaam." ".$client->familienaam;
                 $omschrijving = \App\Helper::getServiceOmschrijving($dienst->serviceable_id, $dienst->serviceable_type);
                 // dd($dienst);
               @endphp
               <tr>
                  <td>{{ $type }}</td>
                  <td>{{ $klantnaam }}</td>
                  <td>{{ $omschrijving }}</td>
                  <td>
                     <a class="btn btn-primary" href="/boekhouding/{{ $dienst->serviceable_id }}/{{ $type }}/detail">detail</a>
                   </td>
               </tr>
             @endforeach   
             </tbody>
          </table>
       @endif
     </div>
   </div>
</div>
