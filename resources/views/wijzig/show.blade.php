@extends('layouts.vleugelslayout')

@section('content')
<div class="super-container">
	<h1 class="d-flex justify-content-center">Wijziging/Annulatie aanvraag</h1>
	@include('partials.flash') 
	@php
	// dd($info);
	@endphp
	<wijzigformulier @completed="vermelden" :data="{{ json_encode($info) }}"></wijzigformulier>
</div>
@endsection