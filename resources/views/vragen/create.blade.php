@extends('layouts.vleugelslayout')

@section('content')
<div class="super-container">
	<h1 class="d-flex justify-content-center">Je vraag</h1>
	<div class="container" id="app">
		<klantvraag @completed="vermelden" 
		     :data="{{ $vraag }}"
			 :vragentypes="{{ $vragentypes}}"
		></klantvraag>
	</div>	
</div>
@endsection