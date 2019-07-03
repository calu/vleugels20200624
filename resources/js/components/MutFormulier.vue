<template>
	<div class="container">

		<form method="POST" action="/mutualiteiten"
			  @submit.prevent="onSubmit"
			  @keydown="form.errors.clear($event.target.name)">
			
			<!-- voor- en familienaam -->  
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="naam">naam</label>
					<input type="text" class="form-control" placeholder="naam"
						name="naam" id="naam" v-model="form.naam">
					<div class="invalid-feedback d-block" v-if="form.errors.has('naam')" 
						v-text="form.errors.get('naam')"></div>
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
				this.form.post('/mutualiteiten')
//				  .then( data => this.$emit('completed', data))
				  .then( data => this.spring(data.message))
				  .catch( errors => console.log(errors));
			} else {
				this.form.patch('/mutualiteiten/' + this.form.id)
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

