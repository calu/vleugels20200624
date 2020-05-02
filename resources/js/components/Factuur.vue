<template>
	<div class="col-12 grid-margin">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Factuur {{ form.id }}</h4>    
        
			  	<p class="card-description">
				Als admin kan je hier de data wijzigen 
				 </p> 

				<form class="form-sample" method="POST" 
              		@submit.prevent="onSubmit"
              		@keydown="form.errors.clear($event.target.name)">

					<!--   factuurvolgnummer en jaar worden pro forma als het 0 is -->
					<!--   datum is de factuurdatum, maar moet kunnen gewijzigd worden -->			
					<div class="form-group row" style="margin-bottom: +3.25rem" :key="gewijzigd">
						<label for="factuurnummer" class="col-sm-2 col-form-label  font-weight-bold">factuurnummer</label>
						<span v-if="form.factuurvolgnummer == null">
							<!-- we maken een radiobutton met vraag Pro forma ... Ja? Neen? -->
							<label class="form-check-label">PRO FORMA?</label> 
							<div class="form-check form-check-inline">
							  <input class="form-check-input" type="radio" name="factuurnrradio" id="factuurnrradio1" value="ja" checked @change="onFactuurnr($event)">
							  <label class="form-check-label" for="factuurnrradio1">Ja</label>
							</div>
							<div class="form-check form-check-inline">
							  <input class="form-check-input" type="radio" name="factuurnrradio" id="factuurnrradio2" value="neen" @change="onFactuurnr($event)">
							  <label class="form-check-label" for="factuurnrradio2">Neen</label>
							</div>													
						</span>
						<span v-if="form.factuurvolgnummer" class="col form-inline">
						    <label for="factuurvolgnummer" class="col-sm-2 col-form-label font-weight-bold">volgnummer</label>
							<div class="col-sm-4 col"> 
								<input type="text" class="form-control" name="factuurvolgnummer" id="factuurvolgnummer"
								       v-model="form.factuurvolgnummer" readonly="readonly">
							    <div class="invalid-feedback d-block" v-if="form.errors.has('factuurvolgnummer')"
								     v-text="form.errors.get('factuurvolgnummer')"></div>	
							</div>
							<label for="jaar" class="col-sm-2 col-form-label font-weight-bold">jaar</label>
							<div class="col-sm-4">							
								<input type="text" class="form-control" name="jaar" id="jaar"
								       v-model="form.jaar" readonly="readonly">
							    <div class="invalid-feedback d-block" v-if="form.errors.has('jaar')"
								     v-text="form.errors.get('jaar')"></div>	
							</div>									 						
						</span>
					</div>	

					<!-- omschrijving tonen + aantal (aantal dagen) -->
					<div class="form-group row" style="margin-top: -3.25rem; margin-bottom: -2.25rem">
						<label class="col-sm-2 col-form-label font-weight-bold">omschrijving</label>	
						<div class="col-sm-6">
							<input type="text" class="form-control-plaintext" id="omschrijving"
							       name="omschrijving" v-model="form.omschrijving"
							       readonly="readonly"  />							
						</div>
						<label class="col-sm-2 col-form-label font-weight-bold">aantal dagen</label>	
						<div class="col-sm-2">
							<input type="text" class="form-control-plaintext" id="aantal"
							       name="aantal" v-model="form.aantal"
							       readonly="readonly"  />							
						</div>						
					</div>	
					
					<!--  stellen eventueel "betaald"
					  en als er ook nog andere zijn - referentie -->
					<div class="form-group row" style="margin-top : +2.25rem; margin-bottom: -2.25rem">						 						
						<!-- als betaald, meld dit -->
						<span v-if="form.betaald == true" class="col-sm-2">	 					
							<div class="form-group col-sm-2">
								<div class="form-group col-sm-2">
								  <span class="text-danger font-weight-bold">betaald</span>
								</div>
							</div>
						</span>
						
						<span @v-if="form.betaald == false" class="col-sm-2">
							<label class="font-weight-bold">betaald</label>
							<input type="checkbox" class="form-check-input" 
								   style="margin-left : +1rem" 
								   name="betaald" id="betaald"
								       v-model="form.betaald"> 
						</span>
						
						<span @v-if="form.referentie != null" class="col-sm-8">
						   <label class="col-sm-3 col-form-label font-weight-bold">referentie</label>
						   <span class="col-sm-4">						   
						   		<input type="text" id="referentie"  name="referentie" v-model="form.referentie" readonly>
						   </span> 
						</span> 
					</div>	
					
					<div class="form-group row" style="margin-top : +2.25rem; margin-bottom: -2.25rem">
						<label class="col-sm-2 col-form-label font-weight-bold">prijs</label>
						<div class="col-sm-2">							
							<input type="text" class="form-control" name="prijs" id="prijs"
							       v-model="form.prijs">
						    <div class="invalid-feedback d-block" v-if="form.errors.has('prijs')"
							     v-text="form.errors.get('prijs')"></div>	
						</div>						
					</div>							
					  									
					<div class="form-group row" style="margin-top : +2rem">
					  <div class="col-sm-12 text-center">Als je de wijziging bevestigt, zal ook gevraagd worden om de factuur te verzenden</div>
					</div>
					<div class="form-group row" style="margin-top : +3rem" >
						<label>&nbsp; </label>
						<button class="btn btn-primary">Bevestig de wijziging</button>
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
			gewijzigd : false,
		}
	},
	
	methods:{
		CalcForm(){ 
			return new Form(this.data);
		}, 
		
		onFactuurnr(event){ 
		  this.form.factuurvolgnummer = this.form.mogelijknr;
		  this.form.jaar = this.form.mogelijkjaar;
		  this.gewijzigd = true;
		},
		
		onSubmit(){
			if (this.form.id == 0){
				this.form.post('/factuur')
					.then( data => this.spring(data.message)) 
					.catch(errors => console.log(errors));
			} else {
			this.form.patch('/factuur/' + this.form.id)
					.then( data => this.spring(data.message))
					.catch( errors => console.log(errors));
			} 
		},
				
		spring(data){
			/* toegevoegd wanneer je bvb van wijzig komt */
 // alert("terug = " + this.data.urlterug); 
			if (typeof this.data.urlterug !== 'undefined'){ 
			  data = this.data.urlterug; 
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
