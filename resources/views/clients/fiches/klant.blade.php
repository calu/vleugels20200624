<section id="klant-section">
	<div class="row">
		<div class="col-12 grid-margin stretch-card">
			<div class="card">
        <h4 class="cord-header">
          <div class="row">
            <div class="col-md-4">Klantgegevens</div>
            <div class="col-md-2 offset-md-6">
              <?php // $clientUrl = "clients/".$client->id."/edit"; 
                $clientUrl="edit";
              ?>
              @include('clients.fiches.editknop',['url' => $clientUrl])
            </div>
          </div>
        </h4>
				<div class="card-body">
					<div class="list-group">
            <div class="row mb-2">
              <div class="col-md-2 font-weight-bold">voornaam : </div>
              <div class="col-md-2">{{ $client->voornaam }}</div>
              <div class="col-md-2 font-weight-bold">familienaam : </div>
              <div class="col-md-4">{{ $client->familienaam }}</div>              
            </div>
             <div class="row mb-2">
                <div class="col-md-2 font-weight-bold">adres : </div>
                <div class="col-md-6">
                  {{ $client->straat }} , {{ $client->huisnummer }} 
                  @if( $client->bus ) 
                    bus : {{ $client->bus }}
                  @endif
                  &nbsp; {{ $client->postcode }}  {{ $client->gemeente }}
                </div>
              </div>
              <div class="row mb-2">
                  <div class="col-md-2 font-weight-bold">telefoon : </div>
                  <div class="col-md-2">{{ $client->telefoon }}</div>
                  <div class="col-md-2 font-weight-bold">gsm : </div>
                  <div class="col-md-4">{{ $client->gsm }}</div>   
              </div>
              <div class="row mb-2">
                  <div class="col-md-2 font-weight-bold">geboortedatum : </div>
                  <div class="col-md-2">{{ $client->geboortedatum }}</div>
                  <div class="col-md-2 font-weight-bold">RRN : </div>
                  <div class="col-md-4">{{ $client->rrn }}</div>   
              </div>   
              
              <?php   
                $mut = \App\Mutualiteit::findOrFail($client->mutualiteit_id);
                $mutnaam = $mut->naam;
              ?>                                     
                <div class="row">
                  <div class="col-md-2 font-weight-bold">statuut : </div>
                  <div class="col-md-2">{{ \App\Enums\StatuutType::getDescription($client->statuut) }}</div>
                  <div class="col-md-2 font-weight-bold">mutualiteit : </div>
                  <div class="col-md-4">{{ $mutnaam }}</div>   
              </div>                        

            </div>
           
          </div>
				</div>
			</div>
		</div>
	</div>
</section>
