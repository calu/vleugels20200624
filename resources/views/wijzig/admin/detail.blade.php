@extends('layouts.vleugelslayout')
@php
// dd($info);

@endphp
@section('content')
<div class="super-container">
	@include('partials.flash')
	<h4 class="d-flex justify-content-center">Controleer alle onderdelen alvorens de wijziging goed te keuren</h4>
	@include('wijzig.admin.detail.menubalk')
	<div class="tab-content"  id="pills-tabContent">
		@include('wijzig.admin.detail.wijzig')
		@include('wijzig.admin.detail.service')
		@include('wijzig.admin.detail.client')
		@include('wijzig.admin.detail.contactpersoon')
		@include('wijzig.admin.detail.factuur')
	</div>
</div>
@endsection

