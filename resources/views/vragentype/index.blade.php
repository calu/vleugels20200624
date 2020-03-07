@extends('layouts.vleugelslayout')

@section('content')
<div class="super-container">
	<h1 class="d-flex justify-content-center">Overzicht van de vragentypes</h1>
	<h2 class="d-flex justify-content-center bg-succes font-weight-bold font-italic">
		Plaats nooit meer dan 10 elementen in deze tabel
	</h2>
	<div class="container">
	@if (count($vragentype) > 0)
		<table class="table table-hover table-bordered table-sm table-primary text-dark">
			<thead>
				<th>naam</th>
				<th></th>
			</thead>
			<tbody>
			@foreach($vragentype as $vraagtype)
				<tr>
					<td>{{ $vraagtype->vraagtype }}</td>
					<td>
						<a class="btn btn-primary" href="/vragentype/{{ $vraagtype->id }}/edit" title="Wijzig de invoer" role="button">
							edit
						</a>
					</td>
				</tr>
			@endforeach
			{{ $vragentype->links() }}
			</tbody>
		</table>
	@else
	  <div class="d-flex justify-content-center font-weight-bold">
		  Er zijn nog geen items ingevuld 
	  </div>
	@endif

	<a href="vragentype/create">
		<button class="btn btn-primary">een nieuw type toevoegen</button>
	</a>
	</div>	
</div>
@endsection