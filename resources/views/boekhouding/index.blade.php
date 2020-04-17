@extends('layouts.vleugelslayout')

@section('content')
<div class="super-container">
	@include('boekhouding.menubalk')
	<div class="tab-content" id="pills-tabContent">
		@include('boekhouding.fiches.aangevraagd')
		@include('boekhouding.fiches.goedgekeurd')
		@include('boekhouding.fiches.wijziging')
		@include('boekhouding.fiches.aftewerken')
		@include('boekhouding.fiches.gefactureerd')
	</div>
</div>
@endsection

