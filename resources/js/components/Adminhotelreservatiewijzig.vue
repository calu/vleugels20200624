<template>
	<div class="container">
		<div class="jumbotron jumbotron-fluid p-1">
			<p style="font-size : 1.3rem">
			Beste admin,<br />
			Je krijgt hier een overzicht van alle gegevens voor deze wijzigingsaanvraag.
			Het bovenste deel laat je toe een wijziging door te voeren, de overige
			data is enkel ter info. Er wordt automatisch een mail verstuurd naar de
			contactpersoon.
			</p>
		</div> 

	
		<form method="POST" action="/hotelreservatie/storewijzig"
			  @submit.prevent="onSubmit"
			  @keydown="form.errors.clear($event.target.name)">
			
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="begindatum">begindatum</label>
					<input type="date" class="form-control" 
					   name="begindatum" id="begindatum" v-model="form.begindatum"
				    /> 
				    <div class="invalid-feedback d-block" v-if="form.errors.has('begindatum')"
					     v-text="form.errors.get('begindatum')" />									 
				</div>

				<div class="form-group col-md-6">
					<label for="einddatum">einddatum</label>
					<input type="date" class="form-control" 
					   name="einddatum" id="einddatum" v-model="form.einddatum"
				    /> 
				    <div class="invalid-feedback d-block" v-if="form.errors.has('einddatum')"
					     v-text="form.errors.get('einddatum')" />									 
				</div>			
			</div>
			
			<!-- nu hier de kamer_id en het bedrag -->
			<div class="row">
				<div class="col-md-6">
					<label for="bedrag">bedrag</label>
					<input type="text" class="form-control" id="bedrag"
						name="bedrag" v-model="form.bedrag" />
					<div class="invalid-feedback d-block" 
					   v-if="form.errors.has('bedrag')"
					   v-text="form.errors.get('bedrag')">
					</div>
				</div>

				<div class="col-md-6">
					<label for="kamer_id">hier link naar kamer</label>
					<input type="text" class="form-control" id="kamer_id"
						name="kamer_id" v-model="form.kamer_id" />
					<div class="invalid-feedback d-block" 
					   v-if="form.errors.has('kamer_id')"
					   v-text="form.errors.get('kamer_id')"> 
					</div>
				</div>					
			</div>				
						
			<div class="control mt-2">
				<button class="btn btn-primary">Verzend</button>
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
			if ( this.form.id == 0){
				this.form.post('/hotelreservatie/storewijzig')
                  .then ( data => this.spring(data.message))
				  .catch( errors => console.log(errors));
			} else {
				this.form.patch('/hotelreservatie/' + this.form.id + "/storewijzig")
                  .then ( data => this.spring(data.message))
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

