<template>
	<div class="col-12 grid-margin">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">De reservatiegegevens</h4>     
        
			  	<p class="card-description">
				Als admin kan je hier de data wijzigen
				 </p>

				<form class="form-sample" method="POST" action="/hotels"
              		@submit.prevent="onSubmit"
              		@keydown="form.errors.clear($event.target.name)">
					
					<input type="hidden" name="serviceable_id" id="serviceable_id" :value="this.form.serviceable_id" />
					<input type="hidden" name="serviceable_type" id="serviceable_type" :value="this.form.typedescription" />
					
					<div class="form-group row">
						<label for="begindatum" class="col-sm-2 col-form-label font-weight-bold">begindatum</label>
						<div class="col-sm-4">
							<input type="date" class="form-control" name="begindatum" id="begindatum"
							       v-model="form.begindatum">
						    <div class="invalid-feedback d-block" v-if="form.errors.has('begindatum')"
							     v-text="form.errors.get('begindatum')"></div>				
						</div>	
						<label for="einddatum" class="col-sm-2 col-form-label font-weight-bold">einddatum</label>
						<div class="col-sm-4">
							<input type="date" class="form-control" name="einddatum" id="einddatum"
							       v-model="form.einddatum">
						    <div class="invalid-feedback d-block" v-if="form.errors.has('einddatum')"
							     v-text="form.errors.get('einddatum')"></div>				
						</div>									   
					</div>
					
					<div class="form-group row">
						<label for="aantaldagen" class="col-sm-2 col-form-label font-weight-bold">aantal dagen</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="aantaldagen" id="aantaldagen"
								   :value= "verschil" readonly="readonly" /> 
						</div>				
					</div>
								
					<div class="form-group row" style="margin-top : +3rem" >
						<label>&nbsp; </label>
						<button class="btn btn-primary">Update datum</button>
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
			// aantaldagen :  this.CalcAantaldagen(),
		}
	},
	
	computed:{
	  verschil(){
	    var datum1 = new Date(this.form.begindatum);
		var datum2 = new Date(this.form.einddatum);
		var Difference_In_Time = datum2.getTime() - datum1.getTime(); 
		var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24); 
//	    alert(Difference_In_Days); 
		return Difference_In_Days.toString();
	  }
	},
	
	methods:{
		CalcForm(){
			var extended = this.data.hotel;
			extended.serviceable_id = this.data.serviceable_id;
			extended.serviceable_type = this.data.typedescription; 
			return new Form(extended);
		}, 

/*		CalcAantaldagen()
		{
//			const enddate = new Date(this.einddatun);
//			const begindate = new Date(this.begindatum);
//		    const diff = Math.ceil(parseInt((enddate - begindate) / (24 * 3600 * 1000)));
			
//			const diff = Math.ceil(parseInt(this.enddate - this.begindate) / (24*3600*1000));
//			return diff;

			var date1 = new Date('06/30/2019');
			var date2 = new Date('07/30/2019'); 
			//date2 = new Date(this.begindatum);
			var Difference_In_Time = date2.getTime() - date1.getTime(); 
			var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24); 
//			return Difference_In_Days;
			
//			var datum = Date.parse(this.begindatum);
// var datum = this.form.begindatum;
		    
//			alert(datum); 
return 17;
		},
*/				
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
