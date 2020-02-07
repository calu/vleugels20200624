<div class="card">
  <div class="card-body">
    <h2 class="card-title text-white bg-secondary d-flex justify-content-center">Diensten</h2>

	<div class="cord">
		<div class="card-body">
			<h3 class="card-title text-black bg-primary d-flex justify-content-center">Aangevraagd</h3>
				
			<div class="card-text">
					<table class="table table-hover table-bordered table-sm table-striped text-dark"
	       style="margin: 0px auto">
		<thead>
			<th scope="col">begindatum</th>
			<th scope="col">einddatum</th>
			<th scope="col">prijs</th>
			<th scope="col"></th>
		</thead>
		<tbody>
			<?php 
				// Haal alle services die aangevraagd zijn
				$services = DB::table('serviceables')
				              ->where([ ['serviceable_type', 'App\Hotel'],['client_id', $client->id]])->get();
				// dd($services); 
			?>
			@foreach( $services as $service)
			    <?php // dd($service) ?>
				<?php $hotel = DB::table('hotels')->where([['id', $service->serviceable_id],['status','aangevraagd']])->get()->first(); ?>
				<?php //dd($hotel); ?>
				@if ($hotel != null)
				<tr>
					<td style="width: auto">{{ $hotel->begindatum }}</td>
					<td style="width: auto">{{ $hotel->einddatum }}</td>
					<td style="width: auto">{{ $hotel->bedrag }}</td>
				</tr>
				@endif
			@endforeach
		</tbody>
	</table>

			</div>
		</div>
	</div>
    <div class="card-text">
		<a href="/clients/{{ $client->id }}/hotelcreate">maak een hotelreservatie</a>
    </div>
  </div>
</div>