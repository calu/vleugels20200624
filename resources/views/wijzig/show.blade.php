@extends('layouts.vleugelslayout')

@section('content')
<div class="super-container">
	<h1 class="d-flex justify-content-center">Wijziging/Annulatie aanvraag</h1>
	@include('partials.flash') 
	@php
	// dd($info);
	$info['service']['knop'] = false;
	@endphp
	<!-- we beginnen met een overzicht van de aangevraagde dienst -->
	@include('wijzig.fiches.overzicht')
	<!-- vervolgens geven we een form weer voor de wijziging aan te vragen -->
	<!-- geef eerst uitleg dat het een aanvraag is en dat men contact opneemt voor bespreking -->
	<!-- include('wijzig.fiches.wijzigaanvraag') -->
</div>
@endsection