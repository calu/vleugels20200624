<template>
	<div class="col-12 grid-margin">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Het Facturatie adres</h4>     
        
			  	<p class="card-description">
				Als admin kan je hier de data wijzigen
				 </p>

				<form class="form-sample" method="POST" action="/client"
              		@submit.prevent="onSubmit"
              		@keydown="form.errors.clear($event.target.name)">

					<input type="hidden" name="serviceable_id" id="serviceable_id" :value="this.form.serviceable_id" />
					<input type="hidden" name="serviceable_type" id="serviceable_type" :value="this.form.typedescription" />
					  
					<div class="form-group row">
						<label class="col-sm-2 col-form-label font-weight-bold">voornaam klant</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="voornaam" id="voornaam"
							       v-model="form.voornaam">
							<div class="invalid-feedback d-block" v-if="form.errors.has('voornaam')"
							     v-text="form.errors.get('voornaam')"></div>
						</div>
						<label class="col-sm-2 col-form-label font-weight-bold">familienaam</label>						
						<div class="col-sm-4">
							<input type="text" class="form-control" name="familienaam" id="familienaam"
							       v-model="form.familienaam">
							<div class="invalid-feedback d-block" v-if="form.errors.has('familienaam')"
							     v-text="form.errors.get('familienaam')"></div>
						</div>						
					</div>
					
					<div class="form-group row">
						<label class="col-sm-2 col-form-label font-weight-bold">straat</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="factuur_straat" id="factuur_straat"
							       v-model="form.factuur_straat">
							<div class="invalid-feedback d-block" v-if="form.errors.has('factuur_straat')"
							     v-text="form.errors.get('factuur_straat')"></div>
						</div>
						<label class="col-sm-2 col-form-label font-weight-bold">huisnummer</label>
						<div class="col-sm-2">
							<input type="text" class="form-control" name="factuur_huisnummer" id="factuur_huisnummer"
							       v-model="form.factuur_huisnummer">
							<div class="invalid-feedback d-block" v-if="form.errors.has('factuur_huisnummer')"
							     v-text="form.errors.get('factuur_huisnummer')"></div>
						</div>						
					</div>
					
					<div class="form-group row">
						<label class="col-sm-1 col-form-label font-weight-bold">bus</label>
						<div class="col-sm-1">
							<input type="text" class="form-control" name="factuur_bus" id="factuur_bus"
							       v-model="form.factuur_bus">
							<div class="invalid-feedback d-block" v-if="form.errors.has('factuur_bus')"
							     v-text="form.errors.get('factuur_bus')"></div>
						</div>
						<label class="col-sm-2 col-form-label font-weight-bold">postcode</label>
						<div class="col-sm-1">
							<input type="text" class="form-control" name="factuur_postcode" id="factuur_postcode"
							       v-model="form.factuur_postcode">
							<div class="invalid-feedback d-block" v-if="form.errors.has('factuur_postcode')"
							     v-text="form.errors.get('factuur_postcode')"></div>
						</div>	
						<label class="col-sm-2 col-form-label font-weight-bold">gemeente</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="factuur_gemeente" id="factuur_gemeente"
							       v-model="form.factuur_gemeente">
							<div class="invalid-feedback d-block" v-if="form.errors.has('factuur_gemeente')"
							     v-text="form.errors.get('factuur_gemeente')"></div>
						</div>												
					</div>		
					
					<div class="form-group row">
						<span class="alert alert-warning" role="alert">het e-mail adres is NIET het fake e-mail adres van de klant, maar wel dat van de contactpersoon</span>
					</div>

					<div class="form-group row">
						<label class="col-sm-2 col-form-label font-weight-bold">e-mail</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="factuur_email" id="factuur_email"
							       v-model="form.factuur_email">
							<div class="invalid-feedback d-block" v-if="form.errors.has('factuur_email')"
							     v-text="form.errors.get('factuur_email')"></div>
						</div>					
					</div>						
								
					<div class="form-group row" style="margin-top : +3rem" >
						<label>&nbsp; </label>
						<button class="btn btn-primary">Update facturatie adres</button>
					</div>					

				</form>
			</div>
		</div>
	</div>
 
</template>

<script>
import Form from '../utilities/Form.js'

export default{
	props:['data'],
	
	data(){
		return {
			form : this.CalcForm(),
		}
	},
	
	methods:{
		CalcForm(){
			var extended = this.data.client
			extended.serviceable_id = this.data.service.serviceable_id;
			extended.serviceable_type = this.data.service.typedescription; 
			return new Form(extended);

//			return new Form(this.data);
		}, 
			
		onSubmit(){
			if (this.form.id == 0){
				this.form.post('/clients')
					.then( data => this.spring(data.message)) 
					.catch(errors => console.log(errors));
			} else {
				this.form.patch('/clients/' + this.form.id)
					.then( data => this.spring(data.message))
					.catch( errors => console.log(errors));
			} 
		},
				
		spring(data){
		    var $url = "https://" + window.location.hostname + "/" + data;
			window.location=$url;	
		},
	},
}
</script>

<style scoped>
.invalid-feedback{
   display: block;
}
</style>
