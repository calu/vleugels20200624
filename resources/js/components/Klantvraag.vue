<template>
	<div class="container">

		<form method="POST" action="/vraag"
			  @submit.prevent="onSubmit"
			  @keydown="form.errors.clear($event.target.name)">
			
		  <div class="form-row pt-3">
			<div class="col">
				<label for="vraagtype" class="col-sm-5 col-form-label">vraagtype </label>

				<select class="form-control" name="vraagtype"
				    id="vraagtype" v-model="form.vraagtype">		
					<option v-for="elem in types" v-bind:value='elem.id'>{{ elem.vraagtype }}</option>
				</select>
				<div class="invalid-feedback d-block" v-if="form.errors.has('vraagtype')"
					v-text="form.errors.get('vraagtype')" />								
			</div><!-- col -->	 
		  </div>
		  
		<!-- vraagtype van vragentype -->  
		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="vraag">vraag</label>
				<textarea rows="4"  cols="70" class="form-control" placeholder="vraag"
					name="vraag" id="vraag" v-model="form.vraag">
				</textarea>
				<div class="invalid-feedback d-block" v-if="form.errors.has('vraag')" 
					v-text="form.errors.get('vraag')"></div>
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
	props:['data','vragentypes'],
	
	data(){
		return {
			form : this.CalcForm(),
			types : this.vragentypes,
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
				this.form.post('/vraag')
//				  .then( data => this.$emit('completed', data))
				  .then( data => this.spring(data.message))
				  .catch( errors => console.log(errors));
			} else {
				this.form.patch('/vraag/' + this.form.id)
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

