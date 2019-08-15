@extends('layouts.vleugelslayout')

@section('content')
<div class="super-container">
	<h1 class="d-flex justify-content-center">Overzicht van de kamers</h1>

	<div class="container">
	<table class="table table-hover table-bordered table-sm table-primary text-dark">
		<thead>
			<th>kamernummer</th>
			<th>aantal bedden</th>
			<th>soort</th>
			<th></th>
		</thead>
		<tbody>
		@foreach($kamers as $kamer)
			<tr>
				<td>{{ $kamer->kamernummer }}</td>
				<td>{{ $kamer->aantal_bedden }}</td>
				<td>{{ $kamer->soort }}</td>
				<td>
					<a class="btn btn-primary" href="/kamers/{{ $kamer->id }}" title="detail">detail</a>
					<a class="btn btn-primary" href="/kamers/{{ $kamer->id }}/edit" title="Wijzig de invoer" role="button">
						edit
					</a>
						
						&nbsp;
						<a class="btn btn-primary" href="/kamers/{{ $kamer->id }}/destroy" title="verwijder deze invoer">
							wis
						</a>
				</td>
			</tr>
		@endforeach
		{{ $kamers->links() }}
		</tbody>
	</table>

	<a href="kamers/create">
		<button class="btn btn-primary">Kamer toevoegen</button>
	</a>
	</div>	
</div>
@endsection