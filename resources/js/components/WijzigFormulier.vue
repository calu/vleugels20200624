<template>
	<div class="col-12 grid-margin">
		<div class="alert alert-warning text-center" role="alert">
		Door dit formulier in te vullen en te verzenden vraag je een annulatie of wijziging aan.
		<br/>
		Je zal gecontacteerd worden om de aanvraag af te werken.  
		</div>		
		<form class="form-sample" method="POST" 
      		@submit.prevent="onSubmit"
      		@keydown="form.errors.clear($event.target.name)">
			
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
			return new Form(this.data);
		}, 
			
		onSubmit(){
			if (this.form.id == 0){
				this.form.post('/wijzig')
					.then( data => this.spring(data.message)) 
					.catch(errors => console.log(errors));
			} else {
				this.form.patch('/wijzig/' + this.form.id) 
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
