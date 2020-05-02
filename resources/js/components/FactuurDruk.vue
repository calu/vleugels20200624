<template>
	<div class="col-12 grid-margin">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Factuur {{ form.id }}</h4>    
        
			  	<p class="card-description">
				Als admin kan je hier de data wijzigen 
				 </p> 

				<form class="form-sample" method="POST" 
              		@submit.prevent="onSubmit"
              		@keydown="form.errors.clear($event.target.name)">
					  					  
				     <div class="form-group row" style="margin-bottom: +3.25rem" :key="gewijzigd">
				      <label class="form-check form-check-inline">Moet ik factuur mailen naar contactpersoon?</label>
				      <div class="form-check form-check-inline" style="margin-top: -0.5rem">
					  	<label class="form-check-label" for="ja" style="margin-right : +1rem">Ja</label>
						<input class="form-check-input" style="margin-right : +1rem" type="radio" name="inlineRadioOptions" checked id="ja" value="ja"  @change="onCpJa($event)" >
					  </div>
					  <div class="form-check form-check-inline" style="margin-top: -0.5rem">
					  	<label class="form-check-label" for="neen" style="margin-right : +1rem">Neen</label>
						<input class="form-check-input" style="margin-right : +1rem" type="radio" name="inlineRadioOptions" id="neen" value="neen"  @change="onCpNee($event)">
					  </div> 
					</div>
					
					<div class="form-group row" style="margin-top : +3rem" >
						<label>&nbsp; </label>
						<button class="btn btn-primary">Verzend de factuur</button>
					</div>					
					
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
			gewijzigd : true,	
		}
	},
	
	methods:{
		CalcForm(){ 
			return new Form(this.data);
		}, 
		
		onCpJa(){
			this.gewijzigd = true;
			this.form.inlineRadioOptions = 'ja';
		},
		
		onCpNee(){ 
			this.gewijzigd = false;
			this.form.inlineRadioOptions = "neen"; 
		},
		
		onSubmit(){
			if (this.form.id == 0){
			  alert("[FactuurDruk.vue - onSubmit] error detected : no store");
/*				this.form.post('/factuur')
					.then( data => this.spring(data.message)) 
					.catch(errors => console.log(errors));
 */
			} else {
			this.form.patch('/factuur/' + this.form.id +'/print')
					.then( data => this.spring(data.message))
					.catch( errors => console.log(errors));
			} 
		},
				
		spring(data){
			/* toegevoegd wanneer je bvb van wijzig komt */
 // alert("terug = " + this.data.urlterug); 
			if (typeof this.data.urlterug !== 'undefined'){ 
			  data = this.data.urlterug; 
			} 
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
