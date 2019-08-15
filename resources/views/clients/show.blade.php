@extends('layouts.vleugelslayout')

@section('content')
<div class="super-container">
	<div class="container">
		<h1 class="d-flex justify-content-center">Klantenfiche</h1>

<!--	include('partials.flash') -->
		@include('clients.partials.fiches')
<!--	include('clients.partials.diensten') -->
	</div>
</div>
@endsection