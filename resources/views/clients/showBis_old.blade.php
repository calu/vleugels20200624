@extends('layouts2.ecolandlayout')

@section('content')
<div class="super-container">
	<div class="container">
		<h1 class="d-flex justify-content-center">Klantenfiche</h1>
			
    <!--nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light site-navbar-target" id="ftco-navbar" -->
    <nav class="navbar navbar-expand-lg navbar-light  bg-light  site-navbar-target" id="ftco-navbar">

	    <div class="container">
	      <div class="collapse navbar-collapse justify-content-center" id="ftco-nav">
	        <ul class="navbar-nav nav">
	          <li class="nav-item"><a href="#klant-section" class="nav-link"><span>Klantgegevens</span></a></li>
	          <li class="nav-item"><a href="#login-section" class="nav-link"><span>login</span></a></li>
	          <li class="nav-item"><a href="#facturatie-section" class="nav-link"><span>facturatie</span></a></li>
	          <li class="nav-item"><a href="#contactpersoon-section" class="nav-link"><span>contactpersoon</span></a></li>
	          <li class="nav-item"><a href="#diensten-section" class="nav-link"><span>diensten</span></a></li>
	        </ul>
	      </div>
	    </div>
	  </nav>			

<!--	include('partials.flash') -->
		@include('clients.fiches.klant')	
		@include('clients.fiches.login')
		@include('clients.fiches.facturatie')
		@include('clients.fiches.contactpersoon')
		@include('clients.fiches.diensten')
	</div>
</div>
@endsection