<template>
	<div class="col-12 grid-margin">
		<div class="cord">
			<div class="cord-body">
				<h4 class="card-title">De Factuur</h4>     
        
				<form class="form-sample" method="POST" action="/boekhouding/factuur"
              		@submit.prevent="onSubmit"
              		@keydown="form.errors.clear($event.target.name)">
					  
					  
					<input type="hidden" name="begindatum" id="begindatum" v-model="form.begindatum" />  
					<input type="hidden" name="einddatum" id="einddatum" v-model="form.einddatum" />  
					<input type="hidden" name="aantal_dagen" id="aantal_dagen" v-model="form.aantal_dagen" />  
								
			  		<p class="card-description">Vul hier nog de velden in om de factuur aan te maken</p>
					
					<div class="row">
						<div class="col">
							<label for="factuurnummer" class="col-sm-3 col-form-label">factuurnummer </label>
							<input type="text" class="form-control" name="factuurnummer"
								id="factuurnummer" v-model="form.factuurnummer" />
							<div class="invalid-feedback d-block" v-if="form.errors.has('factuurnummer')"
								v-text="form.errors.get('factuurnummer')" />								
						</div><!-- col -->

						<div class="col">
							<label for="factuurdatum" class="col-sm-3 col-form-label">factuurdatum </label>
							<input type="date" class="form-control" name="factuurdatum"
								id="factuurdatum" v-model="form.factuurdatum" />
							<div class="invalid-feedback d-block" v-if="form.errors.has('factuurdatum')"
								v-text="form.errors.get('factuurdatum')" />								
						</div><!-- col -->						
			 								
						<div class="col">
							<label for="vervaldatum" class="col-sm-3 col-form-label">vervaldatum </label>						
							<input type="date" class="form-control" name="vervaldatum"
								id="vervaldatum" v-model="form.vervaldatum" />
							<div class="invalid-feedback d-block" v-if="form.errors.has('vervaldatum')"
								v-text="form.errors.get('vervaldatum')" />								
						</div><!-- col -->	
					</div><!-- row -->
					
					<div class="row">
						<div class="col-md-4">
							<label for="onzeref" class="col-sm-4 col-form-label">onze ref </label>											
							<input type="text" class="form-control col-sm-4" name="onzeref"
								id="onzeref" v-model="form.onzeref" />
							<div class="invalid-feedback d-block" v-if="form.errors.has('onzeref')"
								v-text="form.errors.get('onzeref')" />								
						</div><!-- col -->
					</div>
					<div class="row">
						<div class="col-md-4">
							<label for="bedragzonder" class=" col-form-label">bedrag (zonder btw) </label>																	
							<input type="text" class="form-control" name="bedragzonder"
								id="bedragzonder" v-model="form.bedragzonder" />
							<div class="invalid-feedback d-block" v-if="form.errors.has('bedragzonder')"
								v-text="form.errors.get('bedragzonder')" />								
						</div><!-- col -->	
						<div class="col">
							<label for="btw" class="col-form-label">btw </label>																	
							<input type="text" class="form-control" name="btw"
								id="btw" v-model="form.btw" />
							<div class="invalid-feedback d-block" v-if="form.errors.has('btw')"
								v-text="form.errors.get('btw')" />								
						</div><!-- col -->		
						<div class="col">
							<label for="bedrag" class=" col-form-label">bedrag </label>																	
							<input type="text" class="form-control" name="bedrag"
								id="bedrag" v-model="form.bedrag" />
							<div class="invalid-feedback d-block" v-if="form.errors.has('bedrag')"
								v-text="form.errors.get('bedrag')" />								
						</div><!-- col -->																	
					</div>
					
					<div class="row">
						<div class="col">
							<label for="omschrijving" class=" col-form-label">omschrijving </label>																	
							<input type="text" class="form-control" name="omschrijving"
								id="omschrijving" v-model="form.omschrijving" />
							<div class="invalid-feedback d-block" v-if="form.errors.has('omschrijving')"
								v-text="form.errors.get('omschrijving')" />								
						</div><!-- col -->	
					</div>
					
					<div class="row">
								
						<div class="col control">
							<button class="btn btn-primary">Verzend</button>							
						</div><!-- col -->
					</div><!-- row -->
  
											 
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
		  // console.log("CalcForm - data = " + this.data);
		  
			return new Form(this.data);
		},
		
		onSubmit(){
			/* console.log("factuur onSubmit");
			throw new Error("geen fout, enkel stoppen"); */
			 
			this.form.post('/boekhouding/factuur')
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
