<section id="reservatie-section">
	<div class="col-12 grid-margin">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Reservatie</h4> 
			  	<p class="card-description">Deze gegevens enkel ter controle</p>
					  
				@php
//				dd($info['this_service']['hotel']);
				$hotel = $info['this_service']['hotel'];
				$begindatum = $hotel->begindatum;
				$einddatum = $hotel->einddatum;
				
				
                $date1 = new \DateTime($hotel->begindatum);
                $date2 = new \DateTime($hotel->einddatum);
                $aantaldagen = $date2->diff( $date1 )->format('%a');				
				@endphp
				
				<form>
					<div class="form-group row" style="margin-bottom: -2.25rem">
						<label class="col-sm-2 col-form-label font-weight-bold">begindatum</label>
						<div class="col-sm-4">
							<input type="text" class="form-control-plaintext" id="begindatum"
							       readonly="readonly" value="{{ $begindatum }}" />							
						</div>
						<label class="col-sm-2 col-form-label font-weight-bold">einddatum</label>	
						<div class="col-sm-4">
							<input type="text" class="form-control-plaintext" id="gsm"
							       readonly="readonly" value="{{ $einddatum }}" />							
						</div>							
					</div>

					<div class="form-group row" style="margin-top: -2.25rem; margin-bottom: -2.25rem">
						<label class="col-sm-2 col-form-label font-weight-bold">aantal dagen</label>
						<div class="col-sm-4">
							<input type="text" class="form-control-plaintext" id="aantal_dagen"
							       readonly="readonly" value="{{ $aantaldagen }}" />							
						</div>
					</div>
					
				</form>
			</div>
		</div>
	</div>	
</section>