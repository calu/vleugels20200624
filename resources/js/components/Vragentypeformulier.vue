<template>
	<div class="container">

		<form method="POST" action="/vragentype"
			  @submit.prevent="onSubmit"
			  @keydown="form.errors.clear($event.target.name)">
			
			
			
			<!-- vraagtype van vragentype -->  
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="vraagtype">vraagtype</label>
					<input type="text" class="form-control" placeholder="vraagtype"
						name="vraagtype" id="vraagtype" v-model="form.vraagtype">
					<div class="invalid-feedback d-block" v-if="form.errors.has('vraagtype')" 
						v-text="form.errors.get('vraagtype')"></div>
				</div>
	
			</div>
			
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
				this.form.post('/vragentype')
//				  .then( data => this.$emit('completed', data))
				  .then( data => this.spring(data.message))
				  .catch( errors => console.log(errors));
			} else {
				this.form.patch('/vragentype/' + this.form.id)
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

