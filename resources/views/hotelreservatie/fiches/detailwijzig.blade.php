
@extends('layouts.vleugelslayout')

@section('content')
<div class="container" id="app">
	<h2 class="d-flex justify-content-center">detail van overnachting aanvraagwijziging</h2> 

	<adminhotelreservatiewijzig @completed="vermelden" 
	    :data="{{ $hotel }}"></adminhotelreservatiewijzig>
		
	@include('hotelreservatie.admin.partials.gegevens');		
</div>
@endsection