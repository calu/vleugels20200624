@extends('layouts.vleugelslayout')

@section('content')
<div class="container">
	<h2 class="d-flex justify-content-center">Overzicht van de contactpersonen</h2>
			               
	@include('contactpersoon.partials.tabel', [ 'data' => $contactpersonenOpen, 'soort' => 'openstaand']);
	@include('contactpersoon.partials.tabel', [ 'data' => $contactpersonenGesloten, 'soort' => 'afgesloten']);	
	<a class="btn btn-primary" href="/contactpersonen/create" 
	   title="een email adres toevoegen" role="button">een contactpersoon toevoegen</a> 	
</div>
@endsection