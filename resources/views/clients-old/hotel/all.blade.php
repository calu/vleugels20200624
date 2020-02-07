<?php
   $services = DB::table('serviceables')
	              ->where([['client_id', $client->id],['serviceable_type', 'App\Hotel']])->get();
   // dd($services);
?>
<div class="row">
	<div class="col-10 grid-margin stretch-card">
		<div class="card">
			<div class="card-header text-capitalize">
				alle hotelreservaties voor deze klant
			</div> <!-- end card header -->
			
			<div class="card-body">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<th scope="col">begindatum</th>
							<th scope="col">einddatum</th>
							<th scope="col">kamer</th>
							<th scope="col">prijs</th>
							<th scope="col">status</th>
							<th scope="col"></th>
						</thead>
						<tbody>
						@foreach( $services as $service)
							<?php
				              $hotel = DB::table('hotels')->where('id', $service->serviceable_id)->get()->first(); 
				              //dd($hotel);
				              $begindatum = $hotel->begindatum;
				              $einddatum = $hotel->einddatum;
				              $kamer = DB::table('kamers')->where('id', $hotel->kamer_id)->get()->first();
				              $kamernummer = $kamer->kamernummer;
				              $status = $hotel->status;
			  				?>
							<tr>
								<td scope="row"> {{ $begindatum }} </td>
								<td scope="row"> {{ $einddatum }} </td>
								<td scope="row"> {{ $kamernummer }} </td>
								<td scope="row"> 
									@if ($hotel->bedrag > 0)
									  {{ $hotel->bedrag }}
									@else
	 				                   <a href='#' class='btn btn-rounded btn-danger'>te bepalen</a> 	
									@endif
								</td>
								<td scope="row"> {{ $status }} </td>
								<td>
								    <button onclick="location.href='http://www.example.com'"  type="button" class="btn btn-success btn-rounded btn-icon-text">
								      wijzig
								      <i class="mdi mdi-file-check btn-icon-append"></i>                          
								     </button>									
								</td>
							</tr>			
						@endforeach	
						</tbody>
					</table> <!-- end table striped-->
				</div> <!-- end table responsive-->
			</div> <!-- end card body-->
		</div> <!-- end card -->
	</div> <!-- end grid margin -->
</div> <!-- end -->