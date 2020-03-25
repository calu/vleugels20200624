@extends('layouts.vleugelslayout')

@section('content')
<div class="container">
	@include('hotelreservatie/fiches/overzicht')
	<h2 class="d-flex justify-content-center">reservatie aanvraag voor overnachting</h2> 
	<hotelreservatie @completed="vermelden" :data="{{ $info }}"></hotelreservatie>              	
</div>
@endsection