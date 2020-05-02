<template>
	<div class="col-12 grid-margin">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">De klant gegevens</h4>     
        
			  	<p class="card-description">
				Als admin kan je hier de data wijzigen 
				 </p> 

				<form class="form-sample" method="POST" 
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
							<input type="text" class="form-control" name="straat" id="straat"
							       v-model="form.straat">
							<div class="invalid-feedback d-block" v-if="form.errors.has('straat')"
							     v-text="form.errors.get('straat')"></div>
						</div>
						<label class="col-sm-2 col-form-label font-weight-bold">huisnummer</label>
						<div class="col-sm-2">
							<input type="text" class="form-control" name="huisnummer" id="huisnummer"
							       v-model="form.huisnummer">
							<div class="invalid-feedback d-block" v-if="form.errors.has('huisnummer')"
							     v-text="form.errors.get('huisnummer')"></div>
						</div> 
					</div>
					
					<div class="form-group row">
						<label class="col-sm-1 col-form-label font-weight-bold">bus</label>
						<div class="col-sm-1">
							<input type="text" class="form-control" name="bus" id="bus"
							       v-model="form.bus">
							<div class="invalid-feedback d-block" v-if="form.errors.has('bus')"
							     v-text="form.errors.get('bus')"></div>
						</div>
						<label class="col-sm-2 col-form-label font-weight-bold">postcode</label>
						<div class="col-sm-2">
							<input type="text" class="form-control" name="postcode" id="postcode"
							       v-model="form.postcode">
							<div class="invalid-feedback d-block" v-if="form.errors.has('postcode')"
							     v-text="form.errors.get('postcode')"></div>
						</div> 
						<label class="col-sm-2 col-form-label font-weight-bold">gemeente</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="gemeente" id="gemeente"
							       v-model="form.gemeente">
							<div class="invalid-feedback d-block" v-if="form.errors.has('gemeente')"
							     v-text="form.errors.get('gemeente')"></div>
						</div> 						
					</div> 

					<div class="form-group row">
						<label class="col-sm-2 col-form-label font-weight-bold">telefoon</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="telefoon" id="telefoon"
							       v-model="form.telefoon">
							<div class="invalid-feedback d-block" v-if="form.errors.has('telefoon')"
							     v-text="form.errors.get('telefoon')"></div>
						</div>
						<label class="col-sm-2 col-form-label font-weight-bold">gsm</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="gsm" id="gsm"
							       v-model="form.gsm">
							<div class="invalid-feedback d-block" v-if="form.errors.has('gsm')"
							     v-text="form.errors.get('gsm')"></div>
						</div> 
					</div>

					<div class="form-group row">
						<label class="col-sm-2 col-form-label font-weight-bold">geboortedatum</label>
						<div class="col-sm-4">
							<input type="date" class="form-control" name="geboortedatum" id="geboortedatum"
							       v-model="form.geboortedatum">
							<div class="invalid-feedback d-block" v-if="form.errors.has('geboortedatum')"
							     v-text="form.errors.get('geboortedatum')"></div>
						</div>
						<label class="col-sm-2 col-form-label font-weight-bold">mutualiteit</label>
						<div class="col-sm-4">
							<!-- input type="text" class="form-control" name="mutualiteit" id="mutualiteit"
							       v-model="form.mutualiteit" -->
						    <select class="form-control"
							        v-model="form.mutualiteit_id" required >
								<option v-for="mut in form.mutualiteiten" v-bind:value="mut.id"> 
								  {{ mut.naam }}
								</option> 
							</select> 
							<div class="invalid-feedback d-block" v-if="form.errors.has('mutualiteit_id')"
							     v-text="form.errors.get('mutualiteit_id')"></div>
						</div> 									
					</div>	
					<div class="form-group row">
						<label class="col-sm-2 col-form-label font-weight-bold">rijksregisternummer</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="rrn" id="rrn"
							       v-model="form.rrn">
							<div class="invalid-feedback d-block" v-if="form.errors.has('rrn')"
							     v-text="form.errors.get('rrn')"></div>
						</div>
						<label class="col-sm-2 col-form-label font-weight-bold">statuut</label>
						<div class="col-sm-4">
						    <select class="form-control"
							        v-model="form.statuut" required >
								<option v-for="stat in form.statuten" v-bind:value="stat.value"> 
								  {{ stat.key }}
								</option> 
							</select> 
							<div class="invalid-feedback d-block" v-if="form.errors.has('statuut')"
							     v-text="form.errors.get('statuut')"></div>
						</div> 									
					</div>	 
														
					<div class="form-group row" style="margin-top : +3rem" >
						<label>&nbsp; </label>
						<button class="btn btn-primary">Update klant</button>
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
			extended.mutualiteiten = this.data.mutualiteiten;
			extended.statuten = this.data.statuten;
			// alert("ok"); 
			return new Form(extended);

//			return new Form(this.data);
		}, 
			
		onSubmit(){
			if (this.form.id == 0){
/*				this.form.post('/clients')
					.then( data => this.spring(data.message)) 
					.catch(errors => console.log(errors));
*/ alert("[Client.vue] hier mag je nooit komen");
			} else {
			this.form.patch('/clients/' + this.form.id + '/klantupdate')
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
