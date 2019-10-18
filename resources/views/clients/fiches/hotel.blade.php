<section id="hotel-section">
	<div class="row">
		<div class="col-12 grid-margin stretch-card">
			<div class="card">
				<h4 class="card-header">
					<div class="row">
						<div class="col-md-6">Alle hotelreservaties</div>
						<div class="col-md-2 offset-md-4">
							<a href="#" class="btn btn-rounded btn-primary">reserveer</a>
						</div>
					</div> <!-- end row -->
				</h4> <!-- end card header-->	
				
				<div class="card-body">
					<div class="list-group">
						@include('clients.hotel.all')
						@include('clients.hotel.agenda')
					</div> <!-- end list-group -->
				</div>	<!-- end card body-->		
			</div> <!-- end card -->
		</div> <!-- end grid margin-->
	</div> <!-- end row -->
</section> <!-- end -->