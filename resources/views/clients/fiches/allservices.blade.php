<section id="allservices-section">
	<div class="row">
		<div class="col-12 grid-margin stretch-card">
			<div class="card">
				<h4 class="card-header">
					<div class="row">
						<div class="col-md-6">Alle diensten</div>
						<div class="col-md-2 offset-md-4">
			              <?php
			                $clientUrl="edit";
			              ?>
			              @include('clients.fiches.editknop',['url' => $clientUrl])							
						</div>
					</div> <!-- end row -->
				</h4> <!-- end card header-->
				
				<div class="card-body">
					<div class="table-responsive">
						<table class="table">
							<thead class="thead-dark">
								<tr>
									<th scope="col">soort</th>
									<th scope="col">begindatum</th>
									<th scope="col">prijs</th>
									<th scope="col">status</Th>
									<th scope="col"></th>
								</tr>
							</thead>
							<tbody>						
								@foreach($services as $service)
								  @include('clients.utils.items')
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div> <!-- end card -->
		</div> <!-- end grid margin -->
	</div> <!-- end row -->
</section> <!-- end -->