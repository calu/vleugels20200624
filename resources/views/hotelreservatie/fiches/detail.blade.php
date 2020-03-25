@extends('layouts.vleugelslayout')

@section('content')
<div class="container">
	<h2 class="d-flex justify-content-center">detail van overnachting aanvraag {{ $hotel->id }}</h2> 
    
	<!-- Toon nu de details -- begindatum - einddatum - kamer_id - status - bedrag -->
	<div class="form-row">
		<div class="form-group col-md-6">
			<label for="begindatum">begindatum</label>
			<input type="date" class="form-control" 
				   name="begindatum" id="begindatum" value="{{ $hotel->begindatum}}"
				   disabled="disabled"
			/> 
		</div>

		<div class="form-group col-md-6">
			<label for="einddatum">einddatum</label>
			<input type="date" class="form-control" 
				   name="einddatum" id="einddatum" value="{{ $hotel->einddatum }}"
				   disabled="disabled"
			/> 
		</div>
	</div>		
				
	<div class="form-row">
		<div class="form-group col-md-4">
			<label for="kamer_id">kamer</label>
			<input type="text" class="form-control" 
				   name="kamer_id" id="kamer_id" value="{{ $hotel->kamer_id}}"
				   disabled="disabled"
			/> 
		</div>
		@php
			if ($hotel->bedrag == 0)
				$bedraginhoud = "te bepalen";
			else
				$bedraginhoud = $hotel->bedrag;
		@endphp
		<div class="form-group col-md-4">
			<label for="bedrag">bedrag</label>
			<input type="text" class="form-control" 
				   name="bedrag" id="bedrag" value="{{ $bedraginhoud }}"
				   disabled="disabled"
			/> 
		</div>		

		<div class="form-group col-md-4">
			<label for="status">status</label>
			<input type="text" class="form-control" 
					name="status" id="status" value="{{ $hotel->status }}"
				   disabled="disabled"
			/> 
		</div>										
	</div>	
	
	@if ( Auth::user()->admin != 1)		
	<!-- als juiste status en klant hier een wijzigingaanvraag toevoegen -->
	@php
		$client_id = App\Helper::getClient();
		$st = array('aangevraagd', 'goedgekeurd');
	@endphp
	@if( in_array($hotel->status, $st ))
	   <h4 class="d-flex justify-content-center text-info">Wens je een wijziging aan te vragen? Vul dit hieronder aan</h4>
	   <form action="/hotels/{{ $hotel->id }}/wijzig" method="POST">
		   @csrf
		   <input type="hidden" name="hotel_id" id="hotel_id" value="{{ $hotel->id}}" />
		   <input type="hidden" name="client_id" id="client_id" value="{{ $client_id }}" />	   
		   <div class="form-row">
			   <div class="form-group col-md-12">
			   		<textarea class="form-control" rows="5" cols="80" id="wijziging" name="wijziging">
					Klant {{ $client_id }} vraagt een wijziging van de reservatie met id = {{ $hotel->id }} : vul hier aan	   
					</textarea>
				</div>
		   </div>
		   <div class="form-row">
			   <div class="form-group col-md-12">
				   <button class="btn btn-primary">verzend</button>
				</div>
			</div>
	   </form>   
	@endif
	<!-- als juiste status en klant hier een annulatieaanvraag toevoegen -->
	
	<!-- als klant -- mogelijk om een vraag te stellen -->
	
	@endif

</div>
@endsection