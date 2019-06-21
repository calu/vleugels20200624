@extends('layouts.vleugelslayout')

@section('content')
<div class="container" id="app">
	<vraagformulier @completed="vermelden" :data="{{ $vraag }}"></vraagformulier>
</div>
@endsection
