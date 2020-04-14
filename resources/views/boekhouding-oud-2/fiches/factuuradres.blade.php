<section id="facturatie-section">
	
	<div class="col-12 grid-margin">
		<div class="cord">
			<h4 class="card-title">Het facturatie adres</h4>
				
			<p class="card-description">De betaling gegevens ter controle</p>
<?php  // dd($info); ?>
		<form>
			<div class="row">
				<div class="col-md-10">
					<div class="form-group row">
						<label for="naam" class="col-sm-4 col-form-label">bestemmeling</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" 
							  name="naam" readonly="readonly" value="{{ $info['factuur_naam'] }}" />
						</div>
					</div>
				</div><!-- col-md-4 -->							
			</div><!-- row -->
			
			<div class="row">
				<div class="col">
					<label for="straat" class="col-form-label">straat </label>
				</div>
				<div class="col">
					<input type="text" class="form-control" name="straat"
					       value="{{ $info['factuur_straat'] }}" readonly="readonly" />
				</div>
				
				<div class="col">
					<label for="huisnummer" class="col-form-label">nummer </label>
				</div>
				<div class="col-md-2">
					<input type="text" class="form-control" name="huisnummer"
					       value="{{ $info['factuur_huisnummer'] }}" readonly="readonly" />
				</div>	

				<div class="col">
					<label for="bus" class="col-form-label">bus </label>
				</div>
				<div class="col-md-2">
					<input type="text" class="form-control" name="bus"
					       value="{{ $info['factuur_bus'] }}" readonly="readonly" />
				</div>	
			</div>
			
			<div class="row">
				<div class="col">
					<label for="postcode" class="col-form-label">postcode </label>
				</div>
				<div class="col">
					<input type="text" class="form-control" name="postcode"
					       value="{{ $info['factuur_postcode'] }}" readonly="readonly" />
				</div>
				
				<div class="col">
					<label for="gemeente" class="col-form-label">nummer </label>
				</div>
				<div class="col-md-2">
					<input type="text" class="form-control" name="gemeente"
					       value="{{ $info['factuur_gemeente'] }}" readonly="readonly" />
				</div>	
			</div>		
			
			<div class="row">
				<div class="col">
					<label for="email" class="col-form-label">e-mail </label>
				</div>
				<div class="col">
					<input type="text" class="form-control" name="email"
					       value="{{ $info['factuur_email'] }}" readonly="readonly" />
				</div>
			</div>
				
		</form>
		</div><!-- cord -->
	</div><!-- col-12 -->



</section>