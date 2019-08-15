<template>

	<div class="container">
	<h1>test clietns</h1>
		<form method="POST" action="/clients"
			  @submit.prevent="onSubmit"
			  @keydown="form.errors.clear($event.target.name)">

			<!-- voor- en familienaam -->  
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="voornaam">voornaam</label>
					<input type="text" class="form-control" placeholder="voornaam"
						name="voornaam" id="voornaam" v-model="form.voornaam">
					<div class="invalid-feedback d-block" v-if="form.errors.has('voornaam')" 
						v-text="form.errors.get('voornaam')"></div>
				</div>
	
				<div class="form-group col-md-6">
					<label for="familienaam">familienaam</label>
					<input type="text" class="form-control" placeholder="familienaam"
						name="familienaam" id="familienaam" v-model="form.familienaam">
					<div class="invalid-feedback" v-if="form.errors.has('familienaam')" 
						v-text="form.errors.get('familienaam')"></div>
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
		console.log("onSubmit : " + this.form.id);
			if ( this.form.id == 0){
				this.form.post('/clients')
//				  .then( data => this.$emit('completed', data))
                  .then ( data => this.spring(data.message))
				  .catch( errors => console.log(errors));
			} else {
				this.form.patch('/clients/' + this.form.id)
//				  .then ( data => this.$emit('completed', data) )
                  .then ( data => this.spring(data.message))
				  .catch( errors => console.log(errors));
			}
		}, 
		
		spring(data){
		    var $url = "https://" + window.location.hostname + "/" + data;
			window.location=$url;	
		},
		
		vul_adres_in(){
		  if (event.target.checked)
		  {
  		     this.form.voornaam = this.form.contactpersoon_voornaam;
  		     this.form.familienaam = this.form.contactpersoon_familienaam;
/*  		     this.form.straat = this.form.contactpersoon_straat;
  		     this.form.huisnummer = this.form.contactpersoon_huisnummer;
  		     this.form.bus = this.form.contactpersoon_bus;
  		     this.form.postcode = this.form.contactpersoon_postcode;
  		     this.form.gemeente = this.form.contactpersoon_gemeente;
  		     this.form.telefoon = this.form.contactpersoon_telefoon;
  		     this.form.gsm = this.form.contactpersoon_gsm;
  		     this.form.email = this.form.contactpersoon_email;
*//*  		     this.form. = this.form.contactpersoon_;
  		     this.form. = this.form.contactpersoon_;
*/
			   
		  } else {
		  	 this.form.voornaam = "";
		  	 this.form.familienaam = "";
/*		  	 this.form.straat = "";
		  	 this.form.huisnummer = "";
		  	 this.form.bus = "";
		  	 this.form.postcode = "";
		  	 this.form.gemeente = "";
		  	 this.form.telefoon = "";
		  	 this.form.gsm = "";
		  	 this.form.email = "";
*/ /*		  	 this.form. = "";
		  	 this.form. = "";
*/
		  }  
		},
		
		vul_facturatie_in(){
		  if ( event.target.checked ){
		    // open het onderdeel facturatie
			
		  } else {
		    // kopieer de contactpersoon gegevens naar facturatiegegevens
			console.log('kopieer gegevens contactpersoon naar facturatie');
		  }
		},
	},
}
</script>

<style scoped>
.invalid-feedback{
   display: block;
}
</style>