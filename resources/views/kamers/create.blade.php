@extends('layouts.vleugelslayout')

@section('content')
<div class="container" id="app">
	<kamerformulier @completed="vermelden" :data="{{ $kamer }}"></kamerformulier>
</div>
@endsection
