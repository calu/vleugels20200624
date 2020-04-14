<template>
	<div class="col-12 grid-margin">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">De facturatiegegevens</h4>     
        
			  	<p class="card-description">
				  het officiële factuurnummer krijgt de vorm jaar/volgnummer (vb. 2020/0001)
				  <br />Check de overige rubrieken alvorens te bevestigen
				 </p>

				<form class="form-sample" method="POST" action="/factuur"
              		@submit.prevent="onSubmit"
              		@keydown="form.errors.clear($event.target.name)">
					  
					<!--   factuurvolgnummer en jaar worden pro forma als het 0 is -->
					<!--   datum is de factuurdatum, maar moet kunnen gewijzigd worden -->			
					<div class="form-group row" style="margin-bottom: +2.25rem">
						<label for="factuurnummer" class="col-sm-2 col-form-label  font-weight-bold">factuurnummer</label>
						<span v-if="form.factuurvolgnummer == null">
							<div class="col-sm-10">
								<input type="text" class="form-control-plaintext" id="factuurnummer"
	   							       readonly="readonly" value = 'PRO FORMA' />
							</div>
						</span>
						<span v-if="form.factuurvolgnummer">
							<div class="col-sm-4">
								<input type="text" class="form-control" name="factuurvolgnummer" id="factuurvolgnummer"
								       v-model="form.factuurvolgnummer">
							    <div class="invalid-feedback d-block" v-if="form.errors.has('factuurvolgnummer')"
								     v-text="form.errors.get('factuurvolgnummer')"></div>	
							</div>
							<label for="jaar" class="col-sm-2 col-form-label  font-weight-bold">jaar</label>
							<div class="col-sm-4">							
								<input type="text" class="form-control" name="jaar" id="jaar"
								       v-model="form.jaar">
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
						<span v-if="form.betaald == true">						
							<div class="form-group col-sm-6">
								<div class="form-group col-sm-6">
								  <span class="text-danger font-weight-bold">betaald</span>
								</div>
							</div>
						</span>
						
						<span v-if="form.betaald == false" class="col-sm-6">
							<label class="font-weight-bold">betaald</label>
							<input type="checkbox" class="form-check-input" 
								   style="margin-left : +1rem" 
								   name="betaald" id="betaald"
								       v-model="form.betaald"> 
						</span>
						
						<div class="col-sm-6">
						     <a href="#" class="btn btn-primary">referentie</a>
						</div>
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
					  									
					<div class="form-group row" style="margin-top : +3rem" >
						<label>&nbsp; </label>
						<button class="btn btn-primary">Verzend</button>
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
			return new Form(this.data);
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
