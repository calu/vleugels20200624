<section class="resume-section col-12" id="aanmeldgegevens">    
  <div class="card">
     <h2 class="card-title text-primary text-center">aanmeldgegevens</h2>
		 
	 @if (request()->session()->has('client_id'))
	    <?php
		$id = Session::get('client_id');
		try{
			$user_id = \App\Client::findOrFail($id)->user_id;
			$user_mail = \App\User::findOrFail($user_id)->email;
			// dd($user_mail);
		} catch (Exception $e){
			dd("meld deze fout aan de beheerder ( ERR client/aanmeldgegevens 001)");
		}
		?>
	 @else
	 	<div>Je moet aangemeld zijn als beheerder of klant!</div>
	 @endif
	
 	<form class="form-sample" method="POST" action="/wachtwoord/vergeten">  <!-- /clients/wachtwoordwijzig -->
	  @csrf										  
	  <div class="row">
		 <div class="col">
			  <label for="email" class="col-sm-3 col-form-label">email </label>
			  <input type="text" class="form-control" name="email" value="{{ $user_mail }}"
				id="email" readonly="readonly"></input>						
			</div><!-- col -->
		</div><!-- row -->
		
				
		<div class="row pt-5">
					
			<div class="col control">
				<button class="btn btn-primary">wachtwoord wijzigen</button>		 					
			</div><!-- col --> 
		</div><!-- row -->						 
	</form>

  </div>
</section>