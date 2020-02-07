<section id="login-section">

	<div class="row">
		<div class="col-12 grid-margin stretch-card">
			<div class="card">
        <h4 class="cord-header">
          <div class="row">
            <div class="col-md-4">Aanmeldgegevens</div>
            <div class="col-md-2 offset-md-6">
              <?php // $clientUrl = "clients/".$client->id."/edit"; 
                $clientUrl="edit";
              ?>
              @include('clients.fiches.editknop',['url' => $clientUrl])
            </div>
          </div>
        </h4>
				<div class="card-body">
					<div class="list-group">
            <div class="row mb-2">
              <div class="col-md-2 font-weight-bold">aanmeldnaam : </div>
              <div class="col-md-2">{{ $user->email }}</div>
              <div class="col-md-2 font-weight-bold">wachtwoord : </div>
              <div class="col-md-4">
                <a href="#" class="btn btn-rounded btn-primary">wijzig wachtwoord</a>
              </div>           
            </div>  <!-- end  row-->
          </div>  <!-- end  list-group-->
				</div>  <!-- end  card-body -->
			</div>  <!-- end card -->
		</div>  <!-- end  grid-margin -->
	</div> <!-- end row -->
  
</section>