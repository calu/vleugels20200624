@extends('layouts.vleugelslayout')

@section('content')
<div class="container" id="app">
	<vragentypeformulier @completed="vermelden" :data="{{ $vragentype }}"></vragentypeformulier>
</div>
@endsection
