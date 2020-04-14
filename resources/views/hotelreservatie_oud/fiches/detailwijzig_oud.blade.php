@extends('layouts.vleugelslayout')

@section('content')
<div class="container" id="app">
	@php
//	dd($info);
    $dinfo = json_decode($info);
	@endphp
	<h2 class="d-flex justify-content-center">detail van overnachting aanvraagwijziging {{ $dinfo->wijzig_id}}</h2> 
    
	<adminhotelreservatiewijzig @completed="vermelden" 
	    :data="{{ $hotel }}"></adminhotelreservatiewijzig>
		
	@include('hotelreservatie.admin.partials.gegevens');
</div>
@endsection