@extends('layouts2.majesticlayout')

@section('content')
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0  d-flex flex-row">
      <div class="navbar-brand-wrapper d-flex justify-content-center">
        <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">  
		  	 	<span>klantenfiche</span>		
        </div>  
      </div>
      
      <div class="d-flex p-2 bd-highlight align-items-center justify-content-center mr-lg-4 w-100">
        <span class="display-3 text-primary justify-content-center d-flex">{{ $client->voornaam." ".$client->familienaam }}</span>
      </div>
    </nav>
    
    
    
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          
          <li class="nav-item">
            <a class="nav-link" href="#klant-section">
              <i class="mdi mdi-account menu-icon"></i>
              <span class="menu-title">klantgegevens</span>
            </a>
          </li>
          
           <li class="nav-item">
            <a class="nav-link" href="#login-section">
              <i class="mdi mdi-login menu-icon"></i>
              <span class="menu-title">login</span>
            </a>
          </li>
           
           <li class="nav-item">
            <a class="nav-link" href="#facturatie-section">
              <i class="mdi mdi-library-books menu-icon"></i>
              <span class="menu-title">facturatie</span>
            </a>
          </li>      
           
           <li class="nav-item">
            <a class="nav-link" href="#contactpersoon-section">
              <i class="mdi mdi-contact-mail menu-icon"></i>
              <span class="menu-title">contactpersoon</span>
            </a>
          </li>   
          
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="mdi mdi-server menu-icon"></i>
              <span class="menu-title">aangeboden diensten</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="#allservices-section">alle diensten</a></li>
                <li class="nav-item"> <a class="nav-link" href="#hotel-section">hotel</a></li>
                <li class="nav-item"> <a class="nav-link" href="#hotelreservatie-section">kamer reserveren</a></li>                  
              </ul>
            </div>
          </li>                      
        </ul>
 
      </nav>
      
      
      
     <?php 
	// Haal alle services die aangevraagd zijn
	$services = DB::table('serviceables')
	              ->where('client_id', $client->id)->get();
	 //dd($services); 
?> 
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          @include('clients.fiches.klant')
          @include('clients.fiches.login')
          @include('clients.fiches.facturatie')
          @include('clients.fiches.contactpersoon')
          @include('clients.fiches.allservices')
          @include('clients.fiches.hotel')
          @include('clients.fiches.hotelreservatie')
 
        <!-- content-wrapper ends -->
      
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2018 <a href="https://www.urbanui.com/" target="_blank">Urbanui</a>. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="mdi mdi-heart text-danger"></i></span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
@endsection