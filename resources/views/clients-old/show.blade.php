@extends('layouts2.majesticlayout')

@section('content')
<?php 
 // Haal alle services die aangevraagd zijn
 $services = DB::table('serviceables')
          ->where('client_id', $client->id)->get();
 //dd($services); 
?>

  <div class="container-scroller">      
      <div class="d-flex p-2 bd-highlight align-items-center justify-content-center mr-lg-4 w-100">
        <span class="display-3 text-primary justify-content-center d-flex">{{ $client->voornaam." ".$client->familienaam }}</span>
      </div>
      
      <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->     
        @include('clients.fiches.navbar')
        @include('clients.fiches.main_panel')
      </div>
  </div>
@endsection 