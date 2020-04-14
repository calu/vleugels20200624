@extends('layouts.vleugelslayout')

@section('content')
<div class="container" id="app">
	<h2 class="d-flex justify-content-center">Overzicht van factuur</h2>	
		
	@php
	dd($factuur);
	@endphp
</div>
@endsection
