<template>
	<form class="form-sample" method="POST" action="/clients/contactpersoon"
		@submit.prevent="onSubmit"
		@keydown="form.errors.clear($event.target.name)">
		  					
		<input type="hidden" id="contactpersoon_id" name="contactpersoon_id" v-model="form.id" />					  
		<div class="row">
			<div class="col">
				<label for="voornaam" class="col-sm-3 col-form-label">voornaam </label>
				<input type="text" class="form-control" name="voornaam"
					id="voornaam" v-model="form.voornaam" />
				<div class="invalid-feedback d-block" v-if="form.errors.has('voornaam')"
					v-text="form.errors.get('voornaam')" />								
			</div><!-- col -->
			
			<div class="col">
				<label for="familienaam" class="col-sm-3 col-form-label">familienaam </label>
				<input type="text" class="form-control" name="familienaam"
					id="familienaam" v-model="form.familienaam" />
				<div class="invalid-feedback d-block" v-if="form.errors.has('familienaam')"
					v-text="form.errors.get('familienaam')" />								
			</div><!-- col -->	
		</div><!-- row --> 
		
		<div class="row pt-3 ">
			<div class="col">
				<label for="straat" class="col-sm-3 col-form-label">straat </label>
				<input type="text" class="form-control" name="straat"
					id="straat" v-model="form.straat" />
				<div class="invalid-feedback d-block" v-if="form.errors.has('straat')"
					v-text="form.errors.get('straat')" />								
			</div><!-- col -->
			
			<div class="col"> 
				<label for="huisnummer" class="col-sm-5 col-form-label">huisnummer </label>
				<input type="text" class="form-control" name="huisnummer"
					id="huisnummer" v-model="form.huisnummer" />
				<div class="invalid-feedback d-block" v-if="form.errors.has('huisnummer')"
					v-text="form.errors.get('huisnummer')" />								
			</div><!-- col -->	
			
			<div class="col">
				<label for="bus" class="col-sm-3 col-form-label">bus </label>
				<input type="text" class="form-control" name="bus"
					id="bus" v-model="form.bus" />
				<div class="invalid-feedback d-block" v-if="form.errors.has('bus')"
					v-text="form.errors.get('bus')" />								
			</div><!-- col -->			 
		</div><!-- row -->		
		
		<div class="row">
			<div class="col">
				<label for="postcode" class="col-sm-3 col-form-label">postcode </label>
				<input type="text" class="form-control" name="postcode"
					id="postcode" v-model="form.postcode" />
				<div class="invalid-feedback d-block" v-if="form.errors.has('postcode')"
					v-text="form.errors.get('postcode')" />								
			</div><!-- col -->
			
			<div class="col">
				<label for="gemeente" class="col-sm-3 col-form-label">gemeente </label>
				<input type="text" class="form-control" name="gemeente"
					id="gemeente" v-model="form.gemeente" />
				<div class="invalid-feedback d-block" v-if="form.errors.has('gemeente')"
					v-text="form.errors.get('gemeente')" />								
			</div><!-- col -->	
		</div><!-- row -->		

		<div class="row pt-3">
			<div class="col">
				<label for="telefoon" class="col-sm-3 col-form-label">telefoon </label>
				<input type="text" class="form-control" name="telefoon"
					id="telefoon" v-model="form.telefoon" />
				<div class="invalid-feedback d-block" v-if="form.errors.has('telefoon')"
					v-text="form.errors.get('telefoon')" />								
			</div><!-- col -->
			
			<div class="col">
				<label for="gsm" class="col-sm-3 col-form-label">gsm </label>
				<input type="text" class="form-control" name="gsm"
					id="gsm" v-model="form.gsm" />
				<div class="invalid-feedback d-block" v-if="form.errors.has('gsm')"
					v-text="form.errors.get('gsm')" />								
			</div><!-- col -->	
		</div><!-- row -->		

		<div class="row pt-3">
			<div class="col">
				<label for="relatie" class="col-sm-3 col-form-label">relatie </label>
				<input type="text" class="form-control" name="relatie"
					id="relatie" v-model="form.relatie" />
				<div class="invalid-feedback d-block" v-if="form.errors.has('relatie')"
					v-text="form.errors.get('relatie')" />								
			</div><!-- col -->

			<div class="col">
				<label for="openstaand" class="col-sm-3 col-form-label">openstaand (enkel admin) </label>
				<input type="text" class="form-control" name="openstaand"
					id="openstaand" v-model="form.openstaand" />
				<div class="invalid-feedback d-block" v-if="form.errors.has('openstaand')"
					v-text="form.errors.get('openstaand')" />								
			</div><!-- col -->			
		</div><!-- row -->	
				
		<div class="row pt-5">
			<div class="col control">
				<button class="btn btn-primary">Verzend</button>							
			</div><!-- col --> 
		</div><!-- row -->
	
								 
	</form>

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
		 //   console.log("CalcForm - data = " + this.data);
		  
			return new Form(this.data);
		},
		
		onSubmit(){
			if (this.form.id == 0){	
			// alert("post");		 
				this.form.post('/clients/contactpersoon')
					.then( data => this.spring(data.message)) 
					.catch(errors => console.log(errors));
			} else {
			// alert("patch en id = " + this.form.id);
				this.form.patch('/clients/contactpersoon/' + this.form.id)
					.then( data => this.spring(data.message))
					.catch( errors => console.log(errors));
			}
		},
			
		spring(data){
			/* toegevoegd wanneer je bvb van wijzig komt */
			//  alert("terug = " + this.data.urlterug);  
			if (typeof this.data.urlterug !== 'undefined'){ 
			  data = this.data.urlterug; 
			  // alert('data = ' + this.data.urlterug); 
			} 

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
