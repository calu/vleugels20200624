@extends('layouts.vleugelslayout')

@section('content')
<div class="super-container">
	<div class="container">
		<h1 class="d-flex justify-content-center">Reservatie aanvraag</h1>
			
		<form action="/hotels" method="post">
			{{ csrf_field() }} 
			<!-- hidden : client_id -->
			<input type="hidden" class="form-control" id="client_id" name="client_id" value="{{ $client->id }}" />
			<!-- begindatum en einddatum -->
			<label for="begindatum">Begindatum : </label>
			<input type="date" class="form-control" id="begindatum" name="begindatum" />
			<label for="einddatum">Einddatum : </label>
			<input type="date" class="form-control" id="einddatum" name="einddatum" />
			<!-- bedrag -->
			<label for="bedrag">bedrag : </label>
			<input type="number" class="form-control" id="bedrag" name="bedrag" />
			<!-- drukknop -->
			<button type="submit" class="btn btn-primary">Bevestig</button>
		</form>
	</div>
</div>
@endsection