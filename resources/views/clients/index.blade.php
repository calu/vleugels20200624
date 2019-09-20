@extends('layouts.vleugelslayout')

@section('content')
<div class="super-container">
	<h1 class="d-flex justify-content-center">Overzicht van de klanten</h1>


	<div class="container">
	<table class="table table-hover table-bordered table-sm table-striped text-dark"
	       style="margin: 0px auto">
		<thead>
			<th scope="col">naam</th>
			<th scope="col">geboortedatum</th>
			<th scope="col">contactpersoon</th>
			<th scope="col"></th>
		</thead>
		<tbody>
		@foreach($clients as $client)
		
			<?php
				$contactpersoon = \App\Client::find($client->id)->contactpersoon()->get()->first();
			?>
			<tr>
				<td style="width: auto">{{ $client->voornaam." ".$client->familienaam }}</td>
				<td style="width: auto">{{ $client->geboortedatum}}</td>
				<td style="width: auto">
					<a href="contactpersonen/{{ $contactpersoon->id }}">
						{{ $contactpersoon->voornaam." ".$contactpersoon->familienaam }}</td>
					</a>
				<td>

					@if ( request()->session()->has('client_id') )
					   <?php
						$id_aangemeld = Session::get('client_id');

						//dd($id_aangemeld) ;
						?>
						@if ($id_aangemeld == $client->id)
							<a class="btn btn-danger" href="/clients/{{ $client->id }}/afmelden" role="button">afmelden</a>
						@else
							<a class="btn btn-primary" href="/clients/{{ $client->id }}/aanmelden" role="button">aanmelden</a>
						@endif
					@else
					  <a class="btn btn-primary" href="/clients/{{ $client->id }}/aanmelden" role="button">aanmelden</a>
					@endif

					<a class="btn btn-primary" href="/clients/{{ $client->id }}/showAsAdmin" title="Wijzig de invoer" role="button">
						toon
					</a>
					
					<a class="btn btn-primary" href="/clients/{{ $client->id}}/showAsAdminBis" title="Wijzig de invoer" role="button">
						toon alternatief
					</a>

					&nbsp;
					<a href="/clients/{{ $client->id }}/destroy" title="verwijder deze invoer">
						wis
					</a>
					
				</td>
			</tr>
		@endforeach
		{{ $clients->links() }}
		</tbody>
	</table>
	
	<p>een klant kan enkel toegevoegd worden via een intakegespek</p>

<!--
	<a href="codes/create">
		<button class="btn btn-primary">codes toevoegen</button>
	</a>
-->
	</div>	
</div>
@endsection