<template>
	<div class="col-12 grid-margin">
		<div class="alert alert-warning text-center" role="alert">
		Dit formulier geeft een overzicht van de huidige situatie van de aanvraag.
		<br/>
		Als je wijzigingen aanbrengt, dan best in overleg met de contactpersoon, maar zeker hem
		informeren.
		<br />
		Druk op "bevestig" om de aanvraag af te werken, Druk op "weiger" om de aanvraag te verwerpen
		</div>		
		<form class="form-sample" method="POST" 
      		@submit.prevent="onSubmit"
      		@keydown="form.errors.clear($event.target.name)">
			<div>
				<div class="form-row" :key="weiger">
					<label class="form-check-label form-check-inline">Er werd aangevraagd : </label>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="text" name="showRubriek"
						       id="showRubriek" v-model="form.rubriek" readonly="readonly">
					</div>
					<label class="form-check-label form-check-inline">Wil je dit wijzigen? </label>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="checkbox" name="wijzigRubriek"
						       id="wijzigRubriek" value="ja" @change="onWijzigRubriek($event)">
					</div>
					
					<div class="form-check form-check-inline" style="margin-left : 5em">
					  <label class="form-check-label text-danger" style="margin-right : 0.5em" for="geweigerd">Wil je dit weigeren</label>
					  <input class="form-check-input" type="checkbox" name="geweigerd"
					         id="geweigerd" value="ja" @change="onWeiger($event)">
					</div>				
				</div>	
			</div>
			<div>			
				<!-- toon hier de data - indien wijziging -->		  
				<div v-if="wijzigrubriek" class="form-row" style="margin-bottom: +3.25rem" :key="wijzigrubriek"> 
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
			</div> 		
			<div>
				<div class="form-group row" style="margin-top : +3rem" :key="weiger">
					<label>&nbsp; </label>
						<button class="btn btn-primary">{{ this.knoptekst }}</button>
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
			wijzigrubriek : false,
			weiger : false,
			knoptekst : "Bevestig de wijziging",
		}
	},
	
	mounted : function () {
		//alert("mounted : " + this.form.rubriek);
		if (this.form.rubriek == 'wijziging'){
		  this.wijzigrubriek = true;
		}
	},		
	
	methods:{
		CalcForm(){
			return new Form(this.data);
		}, 	
		
		onWijzigRubriek(){
			if (this.form.rubriek == 'annulatie'){
			  this.form.rubriek = 'wijziging';
			}  
			else
			  this.form.rubriek = 'annulatie'; 
			  if (this.wijzigrubriek)
			    this.wijzigrubriek = false;
			  else
			    this.wijzigrubriek = true;
		},
		
		onWeiger(){
		
			if (this.weiger){
			  this.weiger = false;
			  this.form.wijzigstatus = 'aangevraagd';
			  this.knoptekst = "Bevestig de wijziging";
			} else {
			  this.weiger = true;
			  this.form.wijzigstatus = 'geweigerd';
			  this.knoptekst = "Bevestig de weigering";
			}
		},
		
		onSubmit(){

			if (this.form.id == 0){
				this.form.post('/wijzig/admin')
		 			.then( data => this.spring(data.message)) 
					.catch(errors => console.log(errors));
			} else {
				this.form.patch('/wijzig/admin/' + this.form.id) 
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
