@extends('layouts2.majesticlayout')
@php
/* wat vereenvoudigen */
$klantnaam = $info['client']->voornaam." ".$info['client']->familienaam;

/* We maken hier een array aan met de info voor de fiche factuurs */
$factuur['id'] = 0;
$factuur['factuurvolgnummer'] = $info['this_service']['factuurnummer'];
$factuur['jaar'] =  date('Y');
$factuur['datum'] = $info['this_service']['factuurdatum'];
$factuur['serviceable_id'] = $info['this_service']['serviceable_id'];
$factuur['serviceable_type'] = $info['this_service']['serviceable_type'];
$factuur['omschrijving'] = $info['this_service']['omschrijving'];
$factuur['aantal'] = $info['this_service']['aantal_dagen'];
$factuur['prijs'] = $info['this_service']['hotel']->bedrag;

// dd($factuur);
@endphp
@section('content')
<div class="container-scroller">
	<div class="d-flex p-2 bd-highlight align-items-center justify-content-center mr-lg-4 w-100">
		<span class="display-3 text-primary justify-content-center d-flex">Service voor {{ $klantnaam }}</span>
    </div>	
	
    <div class="container-fluid page-body-wrapper">
	  @include('boekhouding.fiches.navbar')
	  @include('boekhouding.fiches.main_panel')
		@php
	    // dd($info);
		@endphp
	</div>	
</div>
@endsection