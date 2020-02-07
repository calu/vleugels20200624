<section id="contactpersoon-section">
	<div class="row">
		<div class="col-12 grid-margin stretch-card">
			<div class="card">
				<h4 class="card-header">
					<div class="row">
						<div class="col-md-4">Contactpersoon</div>
						<div class="col-md-2 offset-md-6">
			              <?php // $clientUrl = "clients/".$client->id."/edit"; 
			                $clientUrl="edit";
			              ?>
			              @include('clients.fiches.editknop',['url' => $clientUrl])							
						</div>
					</div> <!-- end row -->
				</h4> <!-- end card header-->
				
				<div class="card-body">
					<div class="list-group">
						<div class="row mb-2">
							<div class="col-md-2 font-weight-bold">relatie : </div>
							<div class="col-md-10"> {{ $contactpersoon->relatie }}</div>
						</div>
						
						<div class="row mb-2">
							<div class="col-md-2 font-weight-bold">adres : </div>
							<div class="col-md-10">
								{{ $contactpersoon->straat }}, {{ $contactpersoon->huisnummer }}
								@if ( $contactpersoon->bus)
								  bus : {{ $contactpersoon->bus }}
								@endif
								<br />
								{{ $contactpersoon->postcode }} {{ $contactpersoon->gemeente}}
							</div>
						</div>		
						
						<div class="row mb-2">
							<div class="col-md-2 font-weight-bold">telefoon : </div>
							<div class="col-md-2"> {{ $contactpersoon->telefoon }}</div>
							<div class="col-md-2 font-weight-bold">gsm :</div>
							<div class="col-md-2"> {{ $contactpersoon->gsm }}</div>
						</div>
						
						<div class="row mb-2">
							<div class="col-md-2 font-weight-bold">e-mail : </div>
							<div class="col-md-10"> {{ $contactpersoon->email }}</div>							
						</div>
						
						<div class="row mb-2">
							<div class="col-md-2 font-weight-bold">gevraagde service:</div>
							<div class="col-md-3"> {{ $contactpersoon->rubriek }}</div>		
							<div class="col-md-4">
								<a href="#" class="btn btn-rounded btn-sm btn-success">editeer</a>
							</div>					
						</div>		
						
						<div class="row mb-2">
							<div class="col-md-2 font-weight-bold">vraag :</div>
							<div class="col-md-10"> {{ $contactpersoon->vraag }}</div>
						</div>				
						
					</div> <!-- end list group -->
				</div> <!-- end card body-->
			</div> <!-- end card -->
		<div> <!-- end grid margin -->
	</div> <!-- end row-->
</section> <!-- end -->