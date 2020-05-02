<template>
	<div class="col-12 grid-margin"> 
		<div class="alert alert-warning text-center" role="alert">
		Door dit formulier in te vullen en te verzenden vraag je een annulatie of wijziging aan.
		<br/>
		Je zal gecontacteerd worden om de aanvraag af te werken.  
		</div>		
		<form class="form-sample" method="POST" action="/wijzig"
      		@submit.prevent="onSubmit"
      		@keydown="form.errors.clear($event.target.name)">
			
			<!-- begin met vraag : annulatie of wijziging
			als wijziging :  type dan begindatum / einddatum (in service) - wijzigbaar
			anders : begin en einddatum = null
			-->
			
			<div class="form-row" :key="gewijzigd">
				<label class="form-check-label form-check-inline">soort : </label>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="rubriek" 
						id="rubriekradio1" value="ja" checked @change="onRubriek($event)">
					<label class="form-check-label" for="rubriekradio1">annulatie</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="rubriek" 
						id="rubriekradio2" value="neen" @change="onRubriek($event)">
					<label class="form-check-label" for="rubriekradio1">wijziging</label>
				</div>
				
				<div class="form-check form-check-inline" style="margin-left : 5em">
				  <label class="form-check-label text-danger" style="margin-right : 0.5em" for="geweigerd">geweigerd</label>
				  <input class="form-check-input" type="radio" name="geweigerd"
				         id="geweigerd" @change="onGeweigerd($event)">
				</div>
			</div>	   
			
			<div v-if="gewijzigd" class="form-row" style="margin-bottom: +3.25rem"> 
				<label class="form-check-label form-check-inline">van</label>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="date" name="datumvan"
					       id="datumvan" v-model="form.datumvan">
				    <div class="invalid-feedback d-block" v-if="form.errors.has('datumvan')"
					     v-text="form.errors.get('datumvan')"></div>	
				</div>
				<label class="form-check-label form-check-inline">tot</label>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="date" name="datumtot"
					       id="datumtot" v-model="form.datumtot">
				    <div class="invalid-feedback d-block" v-if="form.errors.has('datumtot')"
					     v-text="form.errors.get('datumtot')"></div>	
				</div> 
			</div>
		
			<div class="form-group row" style="margin-top : +3rem" >
				<label>&nbsp; </label>
				<button class="btn btn-primary">Bevestig de wijziging</button>
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
			gewijzigd : false,
		}
	},
	
	methods:{
		CalcForm(){
			return new Form(this.data);
		}, 
		
		onRubriek(event){
		   this.gewijzigd = true;
		   this.form.rubriek = "wijziging";
		   this.form.wijzigstatus = "aangevraagd";
		   // alert("event"); 
		},
		
		onGeweigerd(event){
		   this.form.wijzigstatus = "geweigerd";
		},
			
		onSubmit(){  
			if (this.form.id == 0){
				this.form.post('/wijzig')
					.then( data => this.spring(data.message)) 
					.catch(errors => console.log(errors));
			} else {
				this.form.patch('/wijzig/' + this.form.id) 
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
