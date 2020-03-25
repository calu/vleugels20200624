<template>
	<div class="container">

		<form method="POST" action="/hotels"
			  @submit.prevent="onSubmit"
			  @keydown="form.errors.clear($event.target.name)">
			  

			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="begindatum">begindatum</label>
					<input type="date" class="form-control" 
					   name="begindatum" id="begindatum" v-model="form.begindatum"
				    /> 
				    <div class="invalid-feedback d-block" v-if="form.errors.has('begindatum')"
					     v-text="form.errors.get('begindatum')" />									 
				</div>

				<div class="form-group col-md-6">
					<label for="einddatum">einddatum</label>
					<input type="date" class="form-control" 
					   name="einddatum" id="einddatum" v-model="form.einddatum"
				    /> 
				    <div class="invalid-feedback d-block" v-if="form.errors.has('einddatum')"
					     v-text="form.errors.get('einddatum')" />									 
				</div>			
			</div>		
						
			<div class="control">
				<button class="btn btn-primary">Reserveer</button>
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
				this.form.post('/hotels')
//				  .then( data => this.$emit('completed', data))
				  .then( data => this.spring(data.message))
				  .catch( errors => console.log(errors));
			} else {
				this.form.patch('/hotels/' + this.form.id)
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

