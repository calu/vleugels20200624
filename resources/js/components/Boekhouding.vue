<template>
	<div class="col-12 grid-margin">
		<div class="cord">
			<div class="cord-body">
				<h4 class="card-title">De facturatiegegevens</h4>     
        
        
				<form class="form-sample" method="POST" action="/boekhouding/bedrag"
              		@submit.prevent="onSubmit"
              		@keydown="form.errors.clear($event.target.name)">
					  
			  		<p class="card-description">Gegevens nodig om het factuurbedrag te bepalen</p>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group row">
								<label for="begindatum" class="col-sm-3 col-form-label">begindatum </label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="begindatum"
										id="begindatum" v-model="form.begindatum"
										readonly="readonly" disabled="disabled" />
								</div><!-- col-sm-6 -->
							</div><!-- form-group row -->
						</div> <!-- col-md-4 -->
						
						<div class="col-md-4">
							<div class="form-group row">
								<label for="einddatum" class="col-sm-3 col-form-label">einddatum </label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="einddatum"
										id="einddatum" v-model="form.einddatum"
										readonly="readonly" disabled="disabled" />
								</div><!-- col-sm-6 -->
							</div><!-- form-group row -->
						</div> <!-- col-md-4 -->						

						<div class="col-md-4">
							<div class="form-group row">
								<label for="aantal_dagen" class="col-sm-4 col-form-label">aantal dagen </label>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="aantal_dagen"
										id="aantal_dagen" v-model="form.aantal_dagen"
										readonly="readonly" disabled="disabled" />
								</div><!-- col-sm-6 -->
							</div><!-- form-group row -->
						</div> <!-- col-md-4 -->						
					</div> <!-- row -->
					
					<div class="row">
						<div class="col">
							<label for="mutualiteit" class="col-form-label">mutualiteit </label>
						</div><!-- col -->
						<div class="col">
							<input type="text" class="form-control" name="mutualiteit"
								id="mutualiteit" v-model="form.mutualiteit"
								readonly="readonly" disabled="disabled" />
						</div><!-- col -->
						<div class="col">
							<label for="statuut" class="col-form-label">statuut </label>
						</div><!-- col -->
						<div class="col">
							<input type="text" class="form-control" name="statuut"
								id="statuut" v-model="form.statuut"
								readonly="readonly" disabled="disabled" />
						</div><!-- col -->
					</div><!-- row -->
					
					<div class="row">
						<div class="col">
							<label for="bedrag" class="col-form-label">bedrag </label>
						</div><!-- col -->
						<div class="col">
							<input type="text" class="form-control" name="bedrag"
								id="bedrag" v-model="form.bedrag" />
							<div class="invalid-feedback d-block" v-if="form.errors.has('bedrag')"
								v-text="form.errors.get('bedrag')" />								
						</div><!-- col -->
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
			/* console.log("boekhouding onSubmit");
			throw new Error("geen fout, enkel stoppen"); */
			
			this.form.post('/boekhouding/bedrag')
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
