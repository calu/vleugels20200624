<template>
	<div class="col-12 grid-margin">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">De Factuur</h4>     
        
				<form class="form-sample" method="POST" action="/clients/factuur"
              		@submit.prevent="onSubmit"
              		@keydown="form.errors.clear($event.target.name)">  
					
					<!-- in dit onderdeel maken we verborgen velden 
					 *    client_id - 
					 *
					 * daarnaast zijn de velden die we tonen de openstaande items waarmee
					 * een factuur kunnen maken
					 *
					 -->
					<input type="hidden" name="client_id" id="client_id" v-model="form.client_id" />
					
					<h3 class="card-title text-center">Overnachtingen</h3>
					<h4 class="card-subtitle text-center">selecteer alle vakjes die in de factuur komen</h4>
					<div class="row">
						<div class="col" />
						<div class="col">begindatum</div>
						<div class="col">einddatum</div>
						<div class="col">kamer</div>
					</div>
					
					<ul class="list-group list-group-flush">
						<li class="list-group-item" v-for="hotel in form.hotels">
						  <input type="hidden" name="client_id" id="client_id" v-model="form.client_id" />
						  <div class="row">
						  	<div class="col">
								<input type="checkbox" class="form-control" :name="hotel.hotelchoice"
							       :id="hotel.hotelchoice"  v-model="hotel.hotelchoice" />
							</div>
							<div class="col">{{ hotel.begindatum }}</div>
							<div class="col">{{ hotel.einddatum }}</div>

							
							<div class="col">{{ hotel.kamernummer }}</div>
						  </div>
						</li>

					</ul>
					<h3 class="card-title text-center">Dagverblijf</h3>
					<h3 class="card-title text-center">Therapie</h3>
					
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
			 
			this.form.post('/clients/factuur')
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
