<section id="contactpersoon-section">
	<div class="col-12 grid-margin">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">contactpersoon</h4> 
			  	<p class="card-description">Deze gegevens enkel ter controle</p>
					  
				@php
				$contactpersoon = $info['contactpersoon'];
				$naam = $contactpersoon->voornaam." ".$contactpersoon->familienaam;
				$adres1 = $contactpersoon->straat.",".$contactpersoon->huisnummer;
				if (strlen($contactpersoon->bus) > 0)
				   $adres1 .= " bus : ".$contactpersoon->bus;
				$adres2 = $contactpersoon->postcode." ".$contactpersoon->gemeente;
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
						<div class="col-sm-6">
							<input type="text" class="form-control-plaintext" id="telefoon"
							       readonly="readonly" value="{{ $contactpersoon->telefoon }}" />							
						</div>
					</div>
					<div class="form-group row" style="margin-top: -2.25rem; margin-bottom: -2.25rem">
						<label class="col-sm-2 col-form-label font-weight-bold">gsm</label>	
						<div class="col-sm-6">
							<input type="text" class="form-control-plaintext" id="gsm"
							       readonly="readonly" value="{{ $contactpersoon->gsm }}" />							
						</div>
					</div>
					<div class="form-group row" style="margin-top: -2.25rem; margin-bottom: -2.25rem">
						<label class="col-sm-2 col-form-label font-weight-bold">e-mail</label>	
						<div class="col-sm-6">
							<input type="text" class="form-control-plaintext" id="email"
							       readonly="readonly" value="{{ $contactpersoon->email }}" />							
						</div>
					</div>																													
				</form>
			</div>
		</div>
	</div>	
</section>