@extends('layouts.vleugelslayout')

@section('content')
<div class="super-container">
	<h1 class="d-flex justify-content-center">Overzicht aanvragen voor wijziging overnachting</h1>
	 @include('partials.flash')
	<div class="container">
		@if ($wijzigingen->count() == 0)
			<h2 class="d-flex justify-content-center text-succes">
				Er zijn geen wijzigingen
			</h2>
		@else
		<table class="table">
			<thead>
				<th>originele data</th>
				<th>aanvraag</th>
				<th></th>
			</thead>
			<tbody>
			@foreach($wijzigingen as $wijziging)
			<!-- hier tonen we de oorspronkelijke data en de aanvraag -->
			@php
			$hotel = \App\Hotel::findOrFail($wijziging->hotel_id);
			$orgdatum = "van ".$hotel->begindatum." tot ".$hotel->einddatum;
			//dd($hotel);
			//dd($wijziging->id);
			@endphp
			<tr>
				<td>{{ $orgdatum }}</td>
				<td>{{ $wijziging->wijziging }}</td>
				<td>
					<a href="/hotelreservatie/{{ $wijziging->id }}/detailwijzig" class="btn btn-primary">detail</a>
				</td>
			@endforeach
			</tbody>
		</table>
		@endif
	<a href="kamers/create">
		<button class="btn btn-primary">Kamer toevoegen</button>
	</a>
	</div>	
</div>
@endsection