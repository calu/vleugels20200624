<template>
	<div class="col-12 grid-margin">
		<div class="alert alert-warning text-center" role="alert">
		Dit formulier geeft een overzicht van de huidige hotelreservatie.
		<br/>
		Als je wijzigingen aanbrengt, dan best in overleg met de contactpersoon, maar zeker hem
		informeren.
		<br />
		Druk op "bevestig" als je wijzigingen hebt aangebracht
		</div>		
		<form class="form-sample" method="POST" 
      		@submit.prevent="onSubmit"
      		@keydown="form.errors.clear($event.target.name)">

			<div class="form-row" style="margin-bottom: +1.25rem">
				<label class="form-check-label form-check-inline">Soort service : </label>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="text" value="Hotel"></input>
				</div>
				
				<label class="form-check-label form-check-inline">Status : </label>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="text" name="status"
					       id="status" v-model="form.status" readonly="readonly">				
				</div>
			</div>

			<div>			
				<!-- toon hier de data -->	  
				<div  class="form-row" style="margin-bottom: +1.25rem"> 
					<label class="form-check-label form-check-inline">van</label>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="date" name="begindatum"
						       id="begindatum" v-model="form.begindatum">
					    <div class="invalid-feedback d-block" v-if="form.errors.has('begindatum')"
						     v-text="form.errors.get('begindatum')"></div>	
					</div>
					<label class="form-check-label form-check-inline">tot</label>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="date" name="einddatum"
						       id="einddatum" v-model="form.einddatum">
					    <div class="invalid-feedback d-block" v-if="form.errors.has('einddatum')"
						     v-text="form.errors.get('einddatum')"></div>	
					</div> 
				</div>			
			</div> 	
			
			<div>
				<div class="form-row" style="margin-bottom: +1.25rem">
					<label class="form-check-label form-check-inline">bedrag</label>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="text" name="bedrag" id="bedrag" v-model="form.bedrag">
						<div class="invalid-feedback d-block" v-if="form.errors.has('bedrag')"
						     v-text="form.errors.get('bedrag')"></div> 
					</div>
				</div>
			</div>
			
			<div>
				<div class="form-group row" style="margin-top : +3rem" >
					<label>&nbsp; </label>
						<button class="btn btn-primary">klik als je gewijzigd hebt</button>
				</div>				
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
				this.form.patch('/hotels/' + this.form.id + '/wijzig') 
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
