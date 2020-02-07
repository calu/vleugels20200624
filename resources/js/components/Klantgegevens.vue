<template>
	<form class="form-sample" method="POST" action="/clients/over"
		@submit.prevent="onSubmit"
		@keydown="form.errors.clear($event.target.name)">
		  					
		<input type="hidden" id="client_id" name="client_id" v-model="form.client_id" />					  
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
				<label for="geboortedatum" class="col-sm-5 col-form-label">geboortedatum </label>
				<input type="text" class="form-control" name="geboortedatum"
					id="geboortedatum" v-model="form.geboortedatum" />
				<div class="invalid-feedback d-block" v-if="form.errors.has('geboortedatum')"
					v-text="form.errors.get('geboortedatum')" />								
			</div><!-- col -->
			
			<div class="col">
				<label for="rrn" class="col-sm-5 col-form-label">rijksregisternummer </label>
				<input type="text" class="form-control" name="rrn" placeholder="00.00.00-000.00"
					id="rrn" v-model="form.rrn" />
				<div class="invalid-feedback d-block" v-if="form.errors.has('rrn')"
					v-text="form.errors.get('rrn')" />								
			</div><!-- col -->	
		</div><!-- row -->	
				
		<div class="row pt-3">
			<input type="hidden" name="mutualiteit_id"
			    id="mutualiteit_id" v-model="form.mutualiteit_id" />
			<div class="col">
				<label for="mutualiteit" class="col-sm-5 col-form-label">mutualiteit </label>


				<input type="text" class="form-control" name="mutualiteit"
					id="mutualiteit" v-model="form.mutualiteit" />
					
				<b-form-select v-model="form.mutualiteit" :options="options"></b-form-select>

				<div class="invalid-feedback d-block" v-if="form.errors.has('mutualiteit')"
					v-text="form.errors.get('mutualiteit')" />								
			</div><!-- col -->
			
			<div class="col">
				<input type="hidden" name="statuut_id"
			   	 id="statuut_id" v-model="form.statuut_id" />			
				<label for="statuut" class="col-sm-5 col-form-label">statuut </label>
				<input type="text" class="form-control" name="statuut"
					id="statuut" v-model="form.statuut" />
				<div class="invalid-feedback d-block" v-if="form.errors.has('statuut')"
					v-text="form.errors.get('statuut')" />								
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
			options : [
			{ value:"1", text:"Christelijke mutualiteit"},
			{ value:"2", text:"bond moyson"},
			]
		}
	},
	
	methods:{
		CalcForm(){
		  // console.log("CalcForm - data = " + this.data);
		  
			return new Form(this.data);
		},
		
		onSubmit(){
			/* console.log("Klantgegevens onSubmit");
			throw new Error("geen fout, enkel stoppen");  */
			 
			this.form.post('/clients/over')
			//	.then( data => this.$emit('completed', data))
				.then( data => this.spring(data.message)) 
				.catch(errors => console.log(errors));
		},
		
		
		spring(data){
//			console.log("spring : " + data);
//			throw new Error("geen fout, maar stop");
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
