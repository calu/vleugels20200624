<template>
	<div class="container">

		<form method="POST" action="/vraag"
			  @submit.prevent="onSubmit"
			  @keydown="form.errors.clear($event.target.name)">
			  

			<div class="form-row">
				<div class="form-group col-md-4">
					<label for="vraagsteller">vraag van</label>
					<input type="text" class="form-control" 
					name="vraagsteller" id="vraagsteller" v-model="form.vraagsteller"
					disabled="disabled" /> 
				</div>
				
				<div class="form-group col-md-4">
					<label for="vraagtype">vraagrubriek</label>
					<input type="text" class="form-control" 
					name="vraagtype" id="vraagtype" v-model="form.vraagtype"
					disabled="disabled" /> 
				</div>
				
				<div class="form-group col-md-4">
					<label for="datumvraag">datum aanvraag</label>
					<input type="text" class="form-control" 
					name="datumvraag" id="datumvraag" v-model="form.datumvraag"
					disabled="disabled" /> 
				</div>				
			</div>		
			
			<div class="form-row">
				<div class="form-group col-md-12">
				  <label for="vraag">de vraag</label>
				  <textarea class="form-control"
				    name="vraag" rows="5" cols="60" id="vraag" v-model="form.vraag"
					disabled="disabled" />
				</div>
			</div>
			
			<div class="form-row">
				<div class="form-group col-md-12">
				  <label for="antwoord">Geef hier je antwoord</label>
				  <textarea class="form-control"
				    name="antwoord" rows="5" cols="60" id="antwoord" v-model="form.antwoord"
				  >Tik hier je antwoord</textarea>
				</div> 
		        <div class="invalid-feedback" v-if="form.errors.has('antwoord')" v-text="form.errors.get('antwoord')"></div>
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
				this.form.post('/vraag/antwoord')
//				  .then( data => this.$emit('completed', data))
				  .then( data => this.spring(data.message))
				  .catch( errors => console.log(errors));
			} else {
				this.form.patch('/vraag/' + this.form.id + '/antwoord')
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

