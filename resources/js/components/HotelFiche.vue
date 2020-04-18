<template>
	<div class="col-12 grid-margin">
		<form class="form-sample" method="POST" 
      		@submit.prevent="onSubmit"
      		@keydown="form.errors.clear($event.target.name)">
	   		<div class="form-row">
				<div class="form-group row">
					<label class="col-sm-2 col-form-label font-weight-bold">van : </label>
					<div class="col-sm-4">
						<input type="date" class="form-control" name="begindatum" id="begindatum"
						       v-model="form.begindatum">
						<div class="invalid-feedback d-block" v-if="form.errors.has('begindatum')"
						     v-text="form.errors.get('begindatum')"></div>
					</div>
					<label class="col-sm-2 col-form-label font-weight-bold">tot :</label>						
					<div class="col-sm-4">
						<input type="date" class="form-control" name="einddatum" id="einddatum"
						       v-model="form.einddatum">
						<div class="invalid-feedback d-block" v-if="form.errors.has('einddatum')"
						     v-text="form.errors.get('einddatum')"></div>
					</div>						
				</div>							   
			</div>
			
			<!-- nog kamer? status - bedrag -->
			
			
			<div class="form-group row" style="margin-top : +3rem" v-if="form.knop">
				<label>&nbsp; </label>
				<button class="btn btn-primary">Update Hotel</button>
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
			return new Form(this.data);
		}, 
			
		onSubmit(){
			if (this.form.id == 0){
				this.form.post('/hotels')
					.then( data => this.spring(data.message)) 
					.catch(errors => console.log(errors));
			} else {
				this.form.patch('/hotels/' + this.form.id) 
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
