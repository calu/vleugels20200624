@extends('layouts2.majesticlayout')

@section('content')
<div class="container-scroller">
	<div class="d-flex p-2 bd-highlight align-items-center justify-content-center mr-lg-4 w-100">
		<span class="display-3 text-primary justify-content-center d-flex">Service voor {{ $client->voornaam." ".$client->familienaam }}</span>
    </div>	
	
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->     
      @include('boekhouding.fiches.navbar')
      @include('boekhouding.fiches.main_panel')
    </div>
		<?php 
	       //dd($client); 
		   //dd($info);   
		
		/**
		 straat, huisnummer, bus, postcode, gemeente
		 telefoon, gsm,
		 geboortedatum, rrn
		 mutualiteit_id
		 factuur_naam,
		 factuur_straat, factuur_huisnummer, factuur_bus, factuur_postcode, factuur_gemeente,
		 factuur_email
		 statuut
		 contactpersoon_id
		 
		 (hotel_id)
		 begindatum, einddatum
		 status, bedrag
		 (kamer_id)
		 aantal_bedden, kamer_soort, kamernummer,
		 kamer_beschrijving, kamer_foto
		 
		 **/
		 ?>
	</div>	
</div>
@endsection