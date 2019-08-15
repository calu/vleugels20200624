@extends('layouts.vleugelslayout')

@section('content')
<div class="container" id="app">
	<h2 class="d-flex justify-content-center">Overzicht van contactpersoon</h2>	
	
	<form> 
		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="voornaam">voornaam</label>
				<input type="text" class="form-control" 
					name="voornaam" id="voornaam" value="{{ $contactpersoon->voornaam }}" disabled="disabled">
			</div>

			<div class="form-group col-md-6">
				<label for="familienaam">familienaam</label>
				<input type="text" class="form-control" 
					name="familienaam" id="familienaam" value="{{ $contactpersoon->familienaam }}"  disabled="disabled">
			</div>
		</div>	
		
	    <div class="form-row">
	      <div class="form-group col-md-10">
	        <label for="relatie">relatie met klant</label>
	        <input type="text" class="form-control" name="relatie" id="relatie" value="{{ $contactpersoon->relatie }}" disabled="disabled">
	      </div>
	    </div>		

	    <div class="form-row">
	      <div class="form-group col-md-10">
	        <label for="straat">straat</label>
	        <input type="text" class="form-control" name="straat" id="straat" value="{{ $contactpersoon->straat }}" disabled="disabled">
	      </div>
	
	      <div class="form-group col-md-2">
	        <label for="huisnummer">huisnummer</label>
	        <input type="text" class="form-control" name="huisnummer" id="huisnummer" value="{{ $contactpersoon->huisnummer }}" disabled="disabled">
	      </div>
	    </div>	
		
		<div class="form-row">
	      <div class="form-group col-md-3">
	        <label for="postcode">postcode</label>
	        <input type="text" class="form-control" name="postcode" id="postcode" value="{{ $contactpersoon->postcode }}" disabled="disabled">
	      </div>
	
	      <div class="form-group col-md-5">
	        <label for="gemeente">gemeente</label>
	        <input type="text" class="form-control" name="gemeente" id="gemeente" value="{{ $contactpersoon->gemeente }}" disabled="disabled">
	      </div>
	    </div>	
			
	    <div class="form-row">
	      <div class="form-group col-md-3">
	        <label for="telefoon">telefoon</label>
	        <input type="text" class="form-control" name="telefoon" id="telefoon" value="{{ $contactpersoon->telefoon }}" disabled="disabled">
	      </div>
	
	      <div class="form-group col-md-3">
	        <label for="gsm">gsm</label>
	        <input type="text" class="form-control" name="gsm" id="gsm" value="{{ $contactpersoon->gsm }}" disabled="disabled">
	      </div>
	
	      <div class="form-group col-md-5">
	        <label for="email">email</label>
	        <input type="text" class="form-control" name="email" id="email" value="{{ $contactpersoon->email }}" disabled="disabled">
	      </div>
	    </div>

	    <div class="form-row">
	      <div class="input-group">
	        <div class="input-group-prepend">
	          <span class="input-group-text">Rubriek</span>&nbsp;&nbsp;
	        </div>
			<input class="form-control" type="text" name="rubriek" value="{{ $contactpersoon->rubriek }}" disabled="disabled">
	    </div>
	
	    <div class="form-row">
	      <div class="form-group col-md-12">
	        <label for="vraag">je vraag</label>
	        <textarea class="form-control" rows="5" cols="50" name="vraag" disabled="disabled">{{ $contactpersoon->vraag }}</textarea>
	      </div>
	    </div>
	</form>
	
	<h2 class="d-flex justify-content-center">Overzicht van klanten van deze contactpersoon</h2>	
	<?php		
		$klanten = $contactpersoon->client()->paginate(10);
//		dd($klanten);
	?>
	
	<table class="table table-hover table-bordered table-sm table-primary text-dark">
		<thead>
			<th>voornaam</th>
			<th>familienaam</th>
			<th>link</th>
		</thead>
		<tbody>
			@foreach( $klanten as $klant )
			<tr>
				<td>{{ $klant->voornaam }}</td>
				<td>{{ $klant->familienaam }}</td>
				<td><a href="/clients/{{ $klant->id }}">klik hier</a></td>
			</tr>
			@endforeach
			{{ $klanten->links() }}
		</tbody>
	</table>
</div>
@endsection
