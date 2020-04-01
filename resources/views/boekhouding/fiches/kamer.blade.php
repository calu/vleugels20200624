<section id="kamer-section">
	<div class="col-12 grid-margin">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">kamergegevens</h4> 
			  	<p class="card-description">Deze gegevens enkel ter controle</p>

				@php
				$kamer = $info['this_service']['kamer'];
				@endphp

				<img src="/img/hotelkamers/{{ $kamer->foto }}" 
					 class="card-img-top" alt="foto van kamer.">				
				<form>
					<div class="form-group row" style="margin-bottom: -2.25rem">
						<label for="kamernummer" class="col-sm-2 col-form-label  font-weight-bold">Kamernummer</label>
						<div class="col-sm-10">
							<input type="text" class="form-control-plaintext" id="kamernummer"
							       readonly="readonly" value="{{ $kamer->kamernummer  }}" />
						</div>						
					</div>	
					
					<div class="form-group row" style="margin-top: -2.25rem; margin-bottom: -2.25rem">
						<label class="col-sm-2 col-form-label font-weight-bold">aantal bedden</label>	
						<div class="col-sm-6">
							<input type="text" class="form-control-plaintext" id="aantal_bedden"
							       readonly="readonly" value="{{ $kamer->aantal_bedden }}" />							
						</div>
					</div>
					
					<div class="form-group row" style="margin-top: -2.25rem; margin-bottom: -2.25rem">
						<label class="col-sm-2 col-form-label font-weight-bold">soort</label>	
						<div class="col-sm-6">
							<input type="text" class="form-control-plaintext" id="soort"
							       readonly="readonly" value="{{ $kamer->soort }}" />							
						</div>
					</div>		
					
					<div class="form-group row" style="margin-top: -2.25rem; margin-bottom: -2.25rem">
						<label class="col-sm-2 col-form-label font-weight-bold">beschrijving</label>	
						<div class="col-sm-6">
							<input type="text" class="form-control-plaintext" id="beschrijving"
							       readonly="readonly" value="{{ $kamer->beschrijving }}" />							
						</div>
					</div>																		
				</form>
			</div>
		</div>
	</div>
</section>