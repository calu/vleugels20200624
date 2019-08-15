@extends('layouts.vleugelslayout')

@section('content')
<div class="super-container">
	<div class="container">
		<h1 class="d-flex justify-content-center">Kamerfiche</h1>
			
		@include('kamers.partials.detail')
		<!-- dan later hier de klanten die deze kamer geboekt hebben -->
	</div>
</div>
@endsection