@extends('layouts.vleugelslayout')

@section('content')
<div class="super-container">
	<h1 class="d-flex justify-content-center">Overzicht van de codes</h1>


	<div class="container">
	<table class="table table-hover table-bordered table-sm table-striped text-dark"
	       style="width:50%; margin: 0px auto">
		<thead>
			<th scope="col">statuut</th>
			<th scope="col">activiteit</th>
			<th scope="col">prijs</th>
			<th scope="col"></th>
		</thead>
		<tbody>
		@foreach($codes as $code)
			<tr>
				<td style="width: 10%">{{ $code->statuut }}</td>
				<td style="width: 40%">{{ $code->activiteit}}</td>
				<td style="width: 10%">{{ $code->prijs }}</td>
				<td>
					<a class="btn btn-primary" href="/codes/{{ $code->id }}/edit" title="Wijzig de invoer" role="button">
						<i class="fas fa-edit"></i>
					</a>
						
<!--						&nbsp;
						<a class="btn btn-primary" href="/codes/{{ $code->id }}/destroy" title="verwijder deze invoer">
						  <i class="fas fa-trash-alt"></i>
						</a>
-->
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
<!--
	<a href="codes/create">
		<button class="btn btn-primary">codes toevoegen</button>
	</a>
-->	
	</div>	
</div>
@endsection