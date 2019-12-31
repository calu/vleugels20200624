<section id="contactpersoon-section">
	
	<div class="col-12 grid-margin">
		<div class="cord">
			<h4 class="card-title">de contactpersoon</h4>
				
			<p class="card-description">enkel ter info</p>
<?php  // dd($info); ?>
		<form>
			
			<!-- voor- en familienaam -->  
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="voornaam">voornaam</label>
					<input type="text" class="form-control" 
						name="voornaam" id="voornaam" value="{{ $info['contact_voornaam'] }}" />
				</div>
	
				<div class="form-group col-md-6">
					<label for="familienaam">familienaam</label>
					<input type="text" class="form-control" 
						name="familienaam" id="familienaam" value="{{ $info['contact_familienaam'] }}" />

				</div>
			</div>
			
		    <div class="form-row">
		      <div class="form-group col-md-10">
		        <label for="relatie">relatie met klant</label>
		        <input type="text" class="form-control" name="relatie" id="relatie" value="{{ $info['contact_relatie'] }}" />
		      </div>
		    </div>
		
		    <div class="form-row">
		      <div class="form-group col-md-10">
		        <label for="straat">straat</label>
		        <input type="text" class="form-control" name="straat" id="straat" value="{{ $info['contact_straat'] }}">
		      </div>
		
		      <div class="form-group col-md-2">
		        <label for="huisnummer">huisnummer</label>
		        <input type="text" class="form-control" name="huisnummer" id="huisnummer" value="{{ $info['contact_huisnummer'] }}" />
		      </div>
		    </div>
		
		    <div class="form-row">
		      <div class="form-group col-md-3">
		        <label for="bus">bus</label>
		        <input type="text" class="form-control" name="bus" id="bus" value="{{ $info['contact_bus'] }}" />
		      </div>
		
		      <div class="form-group col-md-3">
		        <label for="postcode">postcode</label>
		        <input type="text" class="form-control" name="postcode" id="postcode" value="{{ $info['contact_postcode'] }}" />
		      </div>
		
		      <div class="form-group col-md-5">
		        <label for="gemeente">gemeente</label>
		        <input type="text" class="form-control" name="gemeente" id="gemeente" value="{{ $info['contact_gemeente'] }}" />
		      </div>
		    </div>
		
		    <div class="form-row">
		      <div class="form-group col-md-3">
		        <label for="telefoon">telefoon</label>
		        <input type="text" class="form-control" name="telefoon" id="telefoon" value="{{ $info['contact_telefoon'] }}" />
		      </div>
		
		      <div class="form-group col-md-3">
		        <label for="gsm">gsm</label>
		        <input type="text" class="form-control" name="gsm" id="gsm" value="{{ $info['contact_gsm'] }}" />
		      </div>
		
		      <div class="form-group col-md-5">
		        <label for="email">email</label>
		        <input type="text" class="form-control" name="email" id="email" value="{{ $info['contact_email'] }}" />
		      </div>
		    </div>
		
				
		</form>
		</div><!-- cord -->
	</div><!-- col-12 -->



</section>