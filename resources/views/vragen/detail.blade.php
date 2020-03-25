@extends('layouts.vleugelslayout')

@section('content')
<div class="super-container">
	<h1 class="d-flex justify-content-center">Overzicht van vraag en antwoord #{{ $vraag['id'] }}</h1>


	<div class="form-row">
		<div class="form-group col-md-4">
			<label for="vraagsteller">vraag van</label>
			<input type="text" class="form-control" 
			name="vraagsteller" id="vraagsteller" value="{{ $vraag['vraagstellernaam'] }}"
			disabled="disabled" /> 
		</div>	
		
		<div class="form-group col-md-4">
			<label for="datumvraag">datum waarop vraag is gesteld</label>
			<input type="text" class="form-control" 
			name="datumvraag" id="datumvraag" value="{{ $vraag['datumvraag'] }}"
			disabled="disabled" /> 
		</div>	
		
		<div class="form-group col-md-4">
			<label for="vraagtypenaam">vraagrubriek</label>
			<input type="text" class="form-control" 
			name="vraagtypenaam" id="vraagtypenaam" value="{{ $vraag['vraagtypenaam'] }}"
			disabled="disabled" /> 
		</div>				
	</div>
	
	<div class="form-row">
		<div class="form-group col">
			<label for="vraag">De gestelde vraag</label>
			<textarea class="form-control" name="vraag" id="vraag" disabled="disabled">{{ $vraag['vraag'] }}</textarea>
		</div>
	</div>

	<div class="form-row">
		<div class="form-group col">
			<label for="antwoord">het antwoord</label>
			<textarea class="form-control" name="antwoord" id="antwoord" disabled="disabled">{{ $vraag['antwoord'] }}</textarea>
		</div>
	</div>
	
	<div class="form-row">
		<div class="form-group col-md-4">
			<label for="datumantwoord">datum waarop vraag werd beantwoord</label>
			<input type="text" class="form-control" 
			name="datumantwoord" id="datumantwoord" value="{{ $vraag['datumantwoord'] }}"
			disabled="disabled" /> 
		</div>			
		
		<div class="form-group col-md-4">
			<a class="btn btn-primary" href="/vraag">terug naar overzicht</a>
		</div>
	</div>
@endsection