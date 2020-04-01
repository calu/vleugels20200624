<section id="facturatie-section">
	
	<div class="col-12 grid-margin">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Facturatie adres</h4>  

			  	<p class="card-description">Deze gegevens enkel ter controle</p>
				@php
				$client = $info['client'];
				$adres = $client->straat.",".$client->huisnummer;
				if (strlen($client->bus) > 0)
				  $adres = $adres." bus : ".$client->bus;
				$gemeente = $client->postcode." ".$client->gemeente;
				@endphp
				<form>
					<div class="form-group row" style="margin-bottom: -2.25rem">
						<label for="naam" class="col-sm-2 col-form-label  font-weight-bold">Bestemmeling</label>
						<div class="col-sm-10">
							<input type="text" class="form-control-plaintext" id="naam"
							       readonly="readonly" value="{{ $client->factuur_naam  }}" />
						</div>
					</div>
					
					<div class="form-group row" style="margin-top: -2.25rem; margin-bottom: -2.25rem">
						<label class="col-sm-2 col-form-label font-weight-bold">adres</label>	
						<div class="col-sm-6">
							<input type="text" class="form-control-plaintext" id="straat"
							       readonly="readonly" value="{{ $adres }}" />							
						</div>
					</div>
					<div class="form-group row" style="margin-top: -2.25rem; margin-bottom: -2.25rem">
						<label class="col-sm-2 col-form-label font-weight-bold">gemeente</label>	
						<div class="col-sm-6">
							<input type="text" class="form-control-plaintext" id="gemeente"
							       readonly="readonly" value="{{ $gemeente }}" />							
						</div>
					</div>
					<div class="form-group row" style="margin-top: -2.25rem; margin-bottom: -2.25rem">
						<label class="col-sm-2 col-form-label font-weight-bold">e-mail</label>	
						<div class="col-sm-6">
							<input type="text" class="form-control-plaintext" id="-email"
							       readonly="readonly" value="{{ $client->email }}" />							
						</div>
					</div>								
				</form>   
        	</div>
		</div>	
    </div>
</section>