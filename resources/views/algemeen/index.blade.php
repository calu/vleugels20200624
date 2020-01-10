@extends('layouts.vleugelslayout')

@section('content')
	<algemeen @completed="vermelden" :data="{{ json_encode($algemeen) }}"></algemeen>
@endsection