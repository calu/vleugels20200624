@extends('layouts.vleugelslayout')

@section('content')
<div class="super-container">
	<h1 class="d-flex justify-content-center">Overzicht van de vragen van de klanten</h1>
	@include('partials.flash')
	
	
	<div class="container">
		<h2 class="d-flex justify-content-center bg-success text-white">
			Overzicht van de vragen die moeten beantwoord worden
		</h2>
		@if (count($onbeantwoord) == 0)
			<h4 class="d-flex justify-content-center text-info">
				Proficiat, je heb alle openstaande vragen beantwoord
			</h4>
		@else
		  <table class="table">  <!--  table-hover table-bordered table-sm table-primary text-dark -->
			  <thead class="thead-dark">
				  <th>vraagsteller</th>
				  <th>type</th>
				  <th>datum</th>
				  <th></th>
			  </thead>
			  <tbody>
			  @foreach( $onbeantwoord as $item)
			  @php
			  // zoek de naam van de klant
			  $vraagsteller = DB::table('clients')->where('id', $item->vraagsteller)->get()->first();
			  $vraagsteller = $vraagsteller->voornaam.' '.$vraagsteller->familienaam;
			  // zoek het vraagtype
			  $vraagtype = DB::table('vragentypes')->where('id', $item->vraagtype)->get()->first()->vraagtype;
			  @endphp
			  <tr>
				  <td>{{ $vraagsteller }}</td>
				  <td>{{ $vraagtype }}</td>
				  <td>{{ $item->datumvraag }}</td>
				  <td>
					  <a class="btn btn-primary" href="vraag/{{ $item->id }}/antwoord">beantwoord</a>
				  </td>
			  @endforeach
			  </tbody>
		  </table>
		@endif
		
		<h2 class="d-flex justify-content-center bg-success text-white">
			Overzicht van de vragen die reeds beantwoord werden
		</h2>		
		@if (count($beantwoord) == 0)
			<h4 class="d-flex justify-content-center text-info">
				Je moet nog alle vragen beantwoorden
			</h4>
		@else
		  <table class="table">  <!--  table-hover table-bordered table-sm table-primary text-dark -->
			  <thead class="thead-dark">
				  <th>vraagsteller</th>
				  <th>type</th>
				  <th>datum</th>
				  <th></th>
			  </thead> 
			  <tbody>
			  @foreach( $beantwoord as $item)
			  @php
			  // zoek de naam van de klant
			  $vraagsteller = DB::table('clients')->where('id', $item->vraagsteller)->get()->first();
			  $vraagsteller = $vraagsteller->voornaam.' '.$vraagsteller->familienaam;
			  // zoek het vraagtype
			  $vraagtype = DB::table('vragentypes')->where('id', $item->vraagtype)->get()->first()->vraagtype;
			  @endphp
			  <tr>
				  <td>{{ $vraagsteller }}</td>
				  <td>{{ $vraagtype }}</td>
				  <td>{{ $item->datumvraag }}</td>
				  <td>
					  <a class="btn btn-primary" href="vraag/{{ $item->id }}/detail">details</a>
				  </td>
			  @endforeach
			  </tbody>
		  </table>
		@endif
</div>
@endsection