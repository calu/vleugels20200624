@extends('layouts.vleugelslayout')

@section('content')
<div class="container-fluid" style="width:100%">
	<h1 class="d-flex justify-content-center">Overzicht aanvragen voor annulatie/wijziging</h1>
	@include('partials.flash') 
	
	<div class="container">
		<h2 class="d-flex justify-content-center bg-success text-white">
			Overzicht van aanpassingen die moeten gebeuren.
		</h2>
	@if (count($wijzig) == 0)
		<h3>Er zijn geen aanvragen voor het ogenblik</h3>
	@else
	  @php
	  $aangevraagd = [];
	  $aanvaard = [];
	  $geweigerd = [];
	  foreach($wijzig as $item){
	    switch ($item->wijzigstatus){
		  case 'aangevraagd' :
		    $aangevraagd[] = $item;
		    break;
		  case 'aanvaard' :
		    $aanvaard[] = $item;
		    break;
		  case 'geweigerd' :
		    $geweigerd[] = $item;
			break;
		}
	    //dd($item);
	  }
	  @endphp
	  @include('wijzig.admin.partial.menubalk')
	  <div class="tab-content" id="pills-tabContent">
		  @include('wijzig.admin.partial.aangevraagd')
		  @include('wijzig.admin.partial.aanvaard')
		  @include('wijzig.admin.partial.geweigerd')
	  </div>
	@endif
	</div>
</div>
@endsection

