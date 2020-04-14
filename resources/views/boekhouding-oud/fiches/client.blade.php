<section id="client-section">
	<div class="col-12 grid-margin">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">klant</h4> 
			  	<p class="card-description">Deze gegevens enkel ter controle</p>
					  
				@php
				// dd($info);
				$client = $info['client'];
				$naam = $client->voornaam." ".$client->familienaam;
				$adres1 = $client->straat.",".$client->huisnummer;
				if (strlen($client->bus) > 0)
				   $adres1 .= " bus : ".$client->bus;
				$adres2 = $client->postcode." ".$client->gemeente;
				
				@endphp
				
				<form>
					<div class="form-group row" style="margin-bottom: -2.25rem">
						<label for="naam" class="col-sm-2 col-form-label  font-weight-bold">naam</label>
						<div class="col-sm-10">
							<input type="text" class="form-control-plaintext" id="naam"
							       readonly="readonly" value="{{ $naam  }}" />
						</div>						
					</div>	

					<div class="form-group row" style="margin-top: -2.25rem; margin-bottom: -2.25rem">
						<label class="col-sm-2 col-form-label font-weight-bold">adres</label>	
						<div class="col-sm-6">
							<input type="text" class="form-control-plaintext" id="adres"
							       readonly="readonly" value="{{ $adres1 }}" />							
						</div>
					</div>

					<div class="form-group row" style="margin-top: -2.25rem; margin-bottom: -2.25rem">
						<label class="col-sm-2 col-form-label font-weight-bold">gemeente</label>	
						<div class="col-sm-6">
							<input type="text" class="form-control-plaintext" id="gemeente"
							       readonly="readonly" value="{{ $adres2 }}" />							
						</div>
					</div>	
					
					<div class="form-group row" style="margin-top: -2.25rem; margin-bottom: -2.25rem">
						<label class="col-sm-2 col-form-label font-weight-bold">telefoon</label>	
						<div class="col-sm-4">
							<input type="text" class="form-control-plaintext" id="telefoon"
							       readonly="readonly" value="{{ $client->telefoon }}" />							
						</div>
						<label class="col-sm-2 col-form-label font-weight-bold">gsm</label>	
						<div class="col-sm-4">
							<input type="text" class="form-control-plaintext" id="gsm"
							       readonly="readonly" value="{{ $client->gsm }}" />							
						</div>
					</div>
					
					
					<div class="form-group row" style="margin-top: -2.25rem; margin-bottom: -2.25rem">
						<label class="col-sm-2 col-form-label font-weight-bold">geboortedatum</label>	
						<div class="col-sm-4">
							<input type="text" class="form-control-plaintext" id="email"
							       readonly="readonly" value="{{ $client->geboortedatum }}" />							
						</div>
						
						<label class="col-sm-2 col-form-label font-weight-bold">rijksregisternr</label>	
						<div class="col-sm-4">
							<input type="text" class="form-control-plaintext" id="email"
							       readonly="readonly" value="{{ $client->rrn }}" />							
						</div>						
					</div>	
					
					<div class="form-group row" style="margin-top: -2.25rem; margin-bottom: -2.25rem">
						<label class="col-sm-2 col-form-label font-weight-bold">mutualiteit</label>	
						<div class="col-sm-4">
							<input type="text" class="form-control-plaintext" id="mut"
							       readonly="readonly" value="{{ $info['mutualiteit'] }}" />							
						</div>
						
						<label class="col-sm-2 col-form-label font-weight-bold">statuut</label>	
						<div class="col-sm-4">
							<input type="text" class="form-control-plaintext" id="stuut"
							       readonly="readonly" value="{{ $info['statuut'] }}" />							
						</div>						
					</div>																																		
				</form>
			</div>
		</div>
	</div>	
</section>