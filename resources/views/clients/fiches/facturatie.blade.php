<section id="facturatie-section">
	<div class="row">
		<div class="col-12 grid-margin stretch-card">
			<div class="card">
				<h4 class="card-header">
					<div class="row">
						<div class="col-md-4">Facturatie</div>
						<div class="col-md-2 offset-md-6">
			              <?php
			                $clientUrl="edit";
			              ?>
			              @include('clients.fiches.editknop',['url' => $clientUrl])						
						</div>
					</div> <!-- end row -->
				</h4> <!-- end card header -->
				
				<div class="card-body">
					<div class="list-group">
						
						<div class="row mb-2">
							<div class="col-md-2 font-weight-bold">geadresseerde : </div>
							<div>{{ $client->factuur_naam }} </div>
						</div>
						
						<div class="row mb-2"> <!-- straat, huisnummer, bus, postcode, gemeente -->
							<div class="col-md-2 font-weight-bold">adres :</div>
							<div class="col-md-10">
							  {{ $client->factuur_straat}}, {{ $client->factuur_huisnummer }}
							  @if( $client->factuur_bus)
							  	bus : {{ $client->factuur_bus }}
							  @endif
							  &nbsp; {{ $client->factuur_postcode}} {{ $client->factuur_gemeente }}
							</div>
						</div>
						
						<!-- email -->
						<div class="row mb-2">
							<div class="col-md-2 font-weight-bold">e-mail : </div>
							<div class="col-md-10"> {{ $client->factuur_email }}</div>
						</div>
						
					</div> <!-- end list group -->
				</div> <!-- end cord body -->
			</div> <!-- end card -->
		</div> <!-- end grid-margin -->
	</div> <!-- end row-->
</section> <!-- end -->
