@extends('hotels.layouts.radissonlayout')

@section('content')
<div class="super-container">
	<!-- de onderstaande variabele betekent dat er nog niet gevraagd 
	     is om te bestellen, maar gewoon een overzicht -->
	<?php $choice = false; ?>
	@include('hotels.partials.banner')
	@include('kamers.partials.warning')
<?php	
/*	
	@if (!auth()->guest())
		@include('kamers.partials.beschikbaarheid')
	@endif
	
*/ ?>	
	@include('kamers.partials.tabel')
</div>
@endsection