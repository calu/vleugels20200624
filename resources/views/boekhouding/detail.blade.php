@extends('layouts.vleugelslayout')
@php


@endphp
@section('content')
<div class="super-container">
	@include('partials.flash')
	<h4 class="d-flex justify-content-center">Controleer alle onderdelen alvorens de factuur goed te keuren</h4>
	@include('boekhouding.detail.menubalk')
	<div class="tab-content"  id="pills-tabContent">
		@include('boekhouding.detail.factuur')
		@include('boekhouding.detail.reservatie')
		@include('boekhouding.detail.factuuradres')
		@include('boekhouding.detail.client')
		@include('boekhouding.detail.contactpersoon')
		@include('boekhouding.detail.kamer')
	</div>
</div>
@endsection

