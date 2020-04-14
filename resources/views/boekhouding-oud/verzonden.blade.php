@extends('layouts.vleugelslayout')

@section('content')
<div class="super-container">
	<h1 class="d-flex justify-content-center">Alle services</h1>
	<div class="container">
		@include('partials.flash');
		
		<p><a href="/home" class="btn btn-primary">terug naar top</a></p>
	</div>	
</div>
@endsection