<div class="tab-pane fade show active" id="pills-factuur" role="tabpanel" aria-labelledby="pills-factuur-tab">
	@php
	//dd($info);
	$factuur_id = $info['factuur']['id'];
	@endphp
	@if ( $factuur_id != 0)
	<hr>
	<h4>Nu kan je een factuur afdrukken met de gegevens die hierboven staan.</h4>
	<p>Controleer dus goed alle gegevens (ook in andere tabbladen) alvorens de factuur op te stellen</p>
	<form method="post" action="/factuur/{{ $factuur_id}}/print">
		@csrf
		
		<input type="hidden" name="factuur_id" value="{{ $factuur_id }}">
		<div class="form-group row">
			<label for="contactpersoon" class="col-form-label font-weight-bold" style="margin-left : 2rem">
				Ook sturen naar de klant (via contactpersoon)?</label>
			<div class="col" style="margin-top : 0.4rem">
				<div class="form-check form-check-inline">
				  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="ja" value="ja" checked="checked">
				  <label class="form-check-label" for="inlineRadio1">Ja</label>
				</div>
				<div class="form-check form-check-inline">
				  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="neen" value="neen">
				  <label class="form-check-label" for="inlineRadio2">Neen</label>
				</div>				
			</div>
		</div>	
		<div class="form-group-row"  style="margin-left : 2rem">
		  <button type="submit" class="btn btn-primary">verstuur</button>	 
		</div>
	</form> 
	@endif
	<boekhouding @completed="vermelden" :data="{{ json_encode($info['factuur']) }}"></boekhouding>		
</div>


