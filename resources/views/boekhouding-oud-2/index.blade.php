@extends('layouts.vleugelslayout')

@section('content')
<div class="super-container">
	<h1 class="d-flex justify-content-center">Alle services</h1>
	<div class="container">
		<table class="table table-hover table-bordered table-sm table-primary text-dark">
			<thead>
				<th>dienst</th>
				<th>startdatum</th>
				<th>status</th>
				<th>klant</th>
				<th></th>
			</thead>
			<tbody>
			@foreach($services as $service)
				<?php 
				     //dd($service->serviceable_type); 
					// decodeer het serviceable_type
					$service_type = App\Enums\ServiceType::getDescription($service->serviceable_type);
					// roep hier een functie op met type en id als argument om gegevens te krijgen
					$dienst = App\Helper::getService($service->serviceable_id, $service->serviceable_type);
					// dd($dienst);
					$begindatum = $dienst->begindatum;
					$client = App\Client::where('id', $service->client_id)->first();
					//dd($client->voornaam);
					$href = "boekhouding/".$service->serviceable_id."/".$service_type."/detail";
				?>
			
			   <tr>
				   <td>{{ $service_type }}</td>
				   <td>{{ $begindatum }}</td>
				   <td>{{ $dienst->status }}</td>
				   <td>{{ $client->voornaam." ".$client->familienaam }}</td>
				   <td>
					   <a href= {{ $href }}>
						   <button class="btn btn-primary">detail</button>
					   </a>	
				   </td>
			   </tr>
			@endforeach
			{{ $services->links() }}
			</tbody>
		</table>
	</div>	
</div>
@endsection