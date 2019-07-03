<template>
	<div class="container">
		
		<form method="POST" action="/codes"
			  @submit.prevent="onSubmit"
			  @keydown="form.errors.clear($event.target.name)">
			
			<!--  -->  
			<div class="form-row">
				<div class="form-group col-md-4">
					<label for="statuut">statuut</label>
					<input type="text" class="form-control" placeholder="statuut"
						name="statuut" id="statuut" v-model="form.statuut" :readonly="true">
					<div class="invalid-feedback d-block" v-if="form.errors.has('statuut')" 
						v-text="form.errors.get('statuut')"></div>
				</div>

				<div class="form-group col-md-4">
					<label for="activiteit">activiteit</label>
					<input type="text" class="form-control" placeholder="activiteit"
						name="activiteit" id="activiteit" v-model="form.activiteit" readonly='readonly'>
					<div class="invalid-feedback d-block" v-if="form.errors.has('activiteit')" 
						v-text="form.errors.get('activiteit')"></div>
				</div>

				<div class="form-group col-md-4">
					<label for="prijs">prijs ( € )</label>
					<input type="text" class="form-control" placeholder="prijs"
						name="prijs" id="prijs" v-model="form.prijs">
					<div class="invalid-feedback d-block" v-if="form.errors.has('prijs')" 
						v-text="form.errors.get('prijs')"></div>
				</div>	
			</div>
			
		
		    <!--div class="control">
		    < !-- de ':disabled="form.errors.any()"' werd weggelaten omdat er problemen
		         zijn als je de telefoon niet invult en daarna wel, maar geen gsm.
		         Je zou moeten ook een spatie in de gsm intikken om te werken.
		         Dit is zeer gebruikersonvriendelijk en wordt daarom weggelaten -- >
		        <button class="button is-primary" >Verzend</button>
		    </div -->
			<div class="control">
				<button class="btn btn-primary">Verzend</button>
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
		}
	},
	
	methods:{
		CalcForm(){
//		  console.log("CalcForm - data = " + this.data);
			return new Form(this.data);
		},
		
		onSubmit(){
//		console.log("onSubmit : " + this.form.id);
			if ( this.form.id == 0){
				this.form.post('/codes')
//				  .then( data => this.$emit('completed', data))
				  .then( data => this.spring(data.message))
				  .catch( errors => console.log(errors));
			} else {
				this.form.patch('/codes/' + this.form.id)
//				  .then ( data => this.$emit('completed', data) )
                  .then ( data => this.spring(data.message))
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

