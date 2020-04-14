<template>
	<div class="col-12 grid-margin">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">De facturatiegegevens</h4>     
        
		
			  	<p class="card-description">het factuurnummer krijgt de vorm jaar/volgnummer (vb. 2020/0001)</p>
        
				<form class="form-sample" method="POST" action="/boekhouding/bedrag"
              		@submit.prevent="onSubmit"
              		@keydown="form.errors.clear($event.target.name)">
				
					<input type="hidden" id="id" name="id" 	v-model="form.id" />
					<input type="hidden" id="aantal" name="aantal" 	v-model="form.aantal" />
					<input type="hidden" id="omschrijving" name="omschrijving" 	v-model="form.omschrijving" />
					<input type="hidden" id="serviceable_id" name="serviceable_id" 	v-model="form.serviceable_id" />
					<input type="hidden" id="serviceable_type" name="serviceable_type" 	v-model="form.serviceable_type" />

					<div class="form-row"> 
						<div class="form-group col-md-4">
							<label for="jaar" class="font-weight-bold">jaar</label>
							<input type="text" class="form-control" name="jaar" id="jaar"
							       v-model="form.jaar">
						    <div class="invalid-feedback d-block" v-if="form.errors.has('jaar')"
							     v-text="form.errors.get('jaar')"></div>						
						</div>
						
						<div class="form-group col-md-4">
							<label for="factuurvolgnummer" class="font-weight-bold">volgnummer</label>
							<input type="text" class="form-control" name="factuurvolgnummer" id="factuurvolgnummer"
							       v-model="form.factuurvolgnummer">
						    <div class="invalid-feedback d-block" v-if="form.errors.has('factuurvolgnummer')"
							     v-text="form.errors.get('factuurvolgnummer')"></div>						
						</div>
						
						
						<div class="form-group col-md-4">
							<label for="datum" class="font-weight-bold">factuurdatum</label>
							<input type="text" class="form-control" name="datum" id="datum"
							       v-model="form.datum">
						    <div class="invalid-feedback d-block" v-if="form.errors.has('datum')"
							     v-text="form.errors.get('datum')"></div>						
						</div>						
					</div>
					
					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="prijs" class="font-weight-bold">prijs</label>
							<input type="text" class="form-control" name="prijs" id="prijs"
							       v-model="form.prijs">
						    <div class="invalid-feedback d-block" v-if="form.errors.has('prijs')"
							     v-text="form.errors.get('prijs')"></div>						
						</div>
						
						<div class="form-group col-md-4 mt-4">
							<label>&nbsp; </label>
							<button class="btn btn-primary">Verzend</button>						</div>						
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
			/* console.log("boekhouding onSubmit");
			throw new Error("geen fout, enkel stoppen"); */
			
			if (this.form.id == 0){
				this.form.post('/boekhouding/bedrag')
					.then( data => this.spring(data.message)) 
					.catch(errors => console.log(errors));
			} else {
				this.form.patch('/boekhouding/' + this.form.id)
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
