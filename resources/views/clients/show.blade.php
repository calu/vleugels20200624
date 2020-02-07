@extends('clients.layouts.resumelayout')

@section('content')
  <div class="container-scroller">      
      <div class="d-flex p-2 bd-highlight align-items-center justify-content-center mr-lg-4 w-100">
        <span class="display-3 text-primary justify-content-center d-flex">Infoblad van {{ $client->voornaam." ".$client->familienaam }}</span>
      </div>
      <div class="container-fluid page-body-wrapper">
        @include('clients.partials.linkermenu') 
        @include('clients.partials.hoofddeel')
      </div>
           
  </div>
@endsection