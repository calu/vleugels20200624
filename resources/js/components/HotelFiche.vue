<template>
	<div class="col-12 grid-margin">
		<form class="form-sample" method="POST" 
      		@submit.prevent="onSubmit"
      		@keydown="form.errors.clear($event.target.name)">
			<div class="form-group row">
				<label class="col-sm-12 col-form-label font-weight-bold">dienst : hotel</label>				
			</div>	
			
			<div class="form-group row">
				<label class="col-sm-2 col-form-label font-weight-bold">van : </label>
				<div class="col-sm-4">
					<input type="date" class="form-control" name="begindatum" id="begindatum"
					       v-model="form.begindatum">
					<div class="invalid-feedback d-block" v-if="form.errors.has('begindatum')"
					     v-text="form.errors.get('begindatum')"></div>
				</div>
				<label class="col-sm-2 col-form-label font-weight-bold">tot :</label>						
				<div class="col-sm-4">
					<input type="date" class="form-control" name="einddatum" id="einddatum"
					       v-model="form.einddatum">
					<div class="invalid-feedback d-block" v-if="form.errors.has('einddatum')"
					     v-text="form.errors.get('einddatum')"></div>
				</div>						
			</div>							   

			
			<div class="form-row">
				<label class="col-sm-2 col-form-label font-weight-bold">status</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" name="status" id="status"
					       v-model="form.status">
					<div class="invalid-feedback d-block" v-if="form.errors.has('status')"
					     v-text="form.errors.get('status')"></div>
				</div>
				<label class="col-sm-2 col-form-label font-weight-bold">bedrag</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" name="bedrag" id="bedrag"
					       v-model="form.bedrag">
					<div class="invalid-feedback d-block" v-if="form.errors.has('bedrag')"
					     v-text="form.errors.get('bedrag')"></div>
				</div>
			</div>
			
			<!-- nog klantnaam / nog contactpersoon : naam / telf / gsm : email -->
			<div class="form-row">
				<label class="col-sm-2 col-form-label font-weight-bold">naam klant </label>
				<div class="col-sm-4">
					<input type="text" class="form-control" name="voornaam" id="voornaam"
					       v-model="form.client.voornaam">
					<div class="invalid-feedback d-block" v-if="form.errors.has('voornaam')"
					     v-text="form.errors.get('voornaam')"></div>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" name="familienaam" id="familienaam"
					       v-model="form.client.familienaam">
					<div class="invalid-feedback d-block" v-if="form.errors.has('familienaam')"
					     v-text="form.errors.get('familienaam')"></div>
				</div>				
			</div>
			
			<div class="form-row">
				<label class="col-sm-12 col-form-label font-weight-bold">gegevens contactpersoon</label>
			</div>

			<div class="form-row">
				<label class="col-sm-2 col-form-label font-weight-bold">naam klant </label>
				<div class="col-sm-4">
					<input type="text" class="form-control" name="voornaam" id="voornaam"
					       v-model="form.contactpersoon.voornaam">
					<div class="invalid-feedback d-block" v-if="form.errors.has('voornaam')"
					     v-text="form.errors.get('voornaam')"></div>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" name="familienaam" id="familienaam"
					       v-model="form.contactpersoon.familienaam">
					<div class="invalid-feedback d-block" v-if="form.errors.has('familienaam')"
					     v-text="form.errors.get('familienaam')"></div>
				</div>	 			
			</div>			
			<div class="form-row">
				<label class="col-sm-2 col-form-label font-weight-bold">telefoon </label>
				<div class="col-sm-4">
					<input type="text" class="form-control" name="telefoon" id="telefoon"
					       v-model="form.contactpersoon.telefoon">
					<div class="invalid-feedback d-block" v-if="form.errors.has('telefoon')"
					     v-text="form.errors.get('telefoon')"></div>
				</div>
				<label class="col-sm-2 col-form-label font-weight-bold">gsm </label>
				<div class="col-sm-4">
					<input type="text" class="form-control" name="gsm" id="gsm"
					       v-model="form.contactpersoon.gsm">
					<div class="invalid-feedback d-block" v-if="form.errors.has('gsm')"
					     v-text="form.errors.get('gsm')"></div> 
				</div>	 			
			</div>				
			<div class="form-row">
				<label class="col-sm-2 col-form-label font-weight-bold">e-mail </label>
				<div class="col-sm-4">
					<input type="text" class="form-control" name="email" id="email"
					       v-model="form.contactpersoon.email">
					<div class="invalid-feedback d-block" v-if="form.errors.has('email')"
					     v-text="form.errors.get('email')"></div>
				</div>			
			</div>				
			<div class="form-group row" style="margin-top : +3rem" v-if="form.knop">
				<label>&nbsp; </label>
				<button class="btn btn-primary">Update Hotel</button>
			</div>			
	   </form>
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
			return new Form(this.data);
		}, 
			
		onSubmit(){
			if (this.form.id == 0){
				this.form.post('/hotels')
					.then( data => this.spring(data.message)) 
					.catch(errors => console.log(errors));
			} else {
				this.form.patch('/hotels/' + this.form.id) 
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
