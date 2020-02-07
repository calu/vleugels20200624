<?php
   $services = DB::table('serviceables')
	              ->where([['client_id', $client->id],['serviceable_type', 'App\Hotel']])->get();
   // dd($services);
?>
<div class="container">
	<div class="col-md-10 grid-margin stretch-card">
	  <div class="card">
	    <div class="card-body">
	      <h4 class="card-title">hotelkalender</h4>
			  
		  <p>nog in te vullen</p>
	    </div>
	  </div>
	</div>
</div>
