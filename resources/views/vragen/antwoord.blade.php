@extends('layouts.vleugelslayout')

@section('content')
<div class="container" id="app">
	<vraagantwoord @completed="vermelden" :data="{{ json_encode($info) }}"></vraagantwoord>
</div>
@endsection
