@extends('layouts.vleugelslayout')

@section('content')
<div class="super-container">
	@include('boekhouding.menubalk')
	<div class="tab-content" id="pills-tabContent">
		@include('boekhouding.fiches.aangevraagd')
	</div>
</div>
@endsection

