<?php
   $services = DB::table('serviceables')
	              ->where([['client_id', $client->id],['serviceable_type', 'App\Hotel']])->get();
   // dd($services);
?>
<div class="container">
	<div class="col-md-10 grid-margin stretch-card">
	  <div class="card">
	    <div class="card-body">
	      <h4 class="card-title">alle hotelbestellingen voor deze klant</h4>

          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>begindatum</th>
        				  <th>einddatum</th>
        				  <th>kamer</th>
                  <th>prijs</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
				      @foreach($services as $service)
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
                <td> {{ $begindatum }} </td>
                <td> {{ $einddatum }} </td>
                <td> {{ $kamernummer }} </td>
                <td> 
                  @if ( $hotel->bedrag > 0 ) 
                    {{  $hotel->bedrag }} 
                  @else  
                    <a href='#' class='btn btn-rounded btn-danger'>te bepalen</a> 
                  @endif</td>
                <td> {{ $status }} </td>
              </td>
              
              @endforeach
			        </tbody>
			       </table>
	      </div>

	    </div>
	  </div>
	</div>
</div>
