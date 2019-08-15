<template>
	<div class="container">
	
		<form method="POST" action="/clients"
			  @submit.prevent="onSubmit"
			  @keydown="form.errors.clear($event.target.name)">

		    <h1 class="d-flex justify-content-center">het intake formulier</h1>
			<div class="jumbotron jumbotron-fluid p-2">
			  <p class="d-block p-2 bg-primary text-white">
			    Contactpersoon = {{ form.contactpersoon_voornaam }} {{ form.contactpersoon_familienaam }}
			  </p>
			  
			  <input type="checkbox" name="contactpersoon-is-client"
			  		v-on:click="vul_adres_in">klik aan als de contactgegevens dezelfde zijn voor de klant</input>
					   
			</div> 	
								
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
		
		    <div class="form-row">
		      <div class="form-group col-md-10">
		        <label for="straat">straat</label>
		        <input type="text" class="form-control" name="straat" id="straat" v-model="form.straat">
		        <div class="invalid-feedback" v-if="form.errors.has('straat')" v-text="form.errors.get('straat')"></div>
		      </div>
		
		      <div class="form-group col-md-2">
		        <label for="huisnummer">huisnummer</label>
		        <input type="text" class="form-control" name="huisnummer" id="huisnummer" v-model="form.huisnummer">
		        <div class="invalid-feedback" v-if="form.errors.has('huisnummer')" v-text="form.errors.get('huisnummer')"></div>
		      </div>
		    </div>
		
		    <div class="form-row">
		      <div class="form-group col-md-3">
		        <label for="bus">bus</label>
		        <input type="text" class="form-control" name="bus" id="bus" v-model="form.bus">
		        <div class="invalid-feedback" v-if="form.errors.has('bus')" v-text="form.errors.get('bus')"></div>
		      </div>
		
		      <div class="form-group col-md-3">
		        <label for="postcode">postcode</label>
		        <input type="text" class="form-control" name="postcode" id="postcode" v-model="form.postcode">
		        <div class="invalid-feedback" v-if="form.errors.has('postcode')" v-text="form.errors.get('postcode')"></div>
		      </div>
		
		      <div class="form-group col-md-5">
		        <label for="gemeente">gemeente</label>
		        <input type="text" class="form-control" name="gemeente" id="gemeente" v-model="form.gemeente">
		        <div class="invalid-feedback" v-if="form.errors.has('gemeente')" v-text="form.errors.get('gemeente')"></div>
		      </div>
		    </div>
		
		    <div class="form-row">
		      <div class="form-group col-md-3">
		        <label for="telefoon">telefoon</label>
		        <input type="text" class="form-control" name="telefoon" id="telefoon" v-model="form.telefoon">
		        <div class="invalid-feedback" v-if="form.errors.has('telefoon')" v-text="form.errors.get('telefoon')"></div>
		      </div>
		
		      <div class="form-group col-md-3">
		        <label for="gsm">gsm</label>
		        <input type="text" class="form-control" name="gsm" id="gsm" v-model="form.gsm">
		        <div class="invalid-feedback" v-if="form.errors.has('gsm')" v-text="form.errors.get('gsm')"></div>
		      </div>		
		    </div>
			
			<div class="border border-primary p-3">
				<div class="form-row">
					<div class="form-group col-md-6">
					  <label for="geboortedatum">geboortedatum</label>
					  <input type="date" class="form-control" name="geboortedatum" id="geboortedatum" v-model="form.geboortedatum">
					  <div class="invalid-feedback" v-if="form.errors.has('geboortedatum')" v-text="form.errors.get('geboortedatum')"></div>
					</div>
					
					<div class="form-group col-md-6">
					  <label for="rrn">rrn</label>
					  <input type="text" class="form-control" name="rrn" id="rrn" v-model="form.rrn">
					  <div class="invalid-feedback" v-if="form.errors.has('rrn')" v-text="form.errors.get('rrn')"></div>
					</div>				
				</div>	
				
				<div class="form-row">
					<div class="form-group col-md-6">
					  <label for="mutualiteit">mutualiteit</label>
					  <select class="form-control" name="mutualiteit" id="mutualiteit" v-model="form.mutualiteit">
					  	<option v-for="mut in form.mutualiteiten">
						  {{ mut.naam }}
						</option>
					  </select>
					  <div class="invalid-feedback" v-if="form.errors.has('mutualiteit')" v-text="form.errors.get('mutualiteit')"></div>
					</div>

					<div class="form-group col-md-6">
					  <label for="statuut">Statuut</label>
					  <select class="form-control" name="statuut" id="statuut" v-model="form.statuut">
					  	<option v-for="statuut in form.statuten">
						  {{ statuut.key }} 
						</option>
					  </select>
					  <div class="invalid-feedback" v-if="form.errors.has('mutualiteit')" v-text="form.errors.get('mutualiteit')"></div>
					</div>					
				</div>						
			</div>
			
			<div class="border border-primary p-3 my-3">
				<div class="form-row">
			      <div class="form-group col-md-5">
			        <label for="email">email ( mag fictief: vb. jan.janssens@fake.be)</label>
			        <input type="text" class="form-control" name="email" id="email" v-model="form.email">
			        <div class="invalid-feedback" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></div>
			      </div>
				  
			      <div class="form-group col-md-5">
			        <label for="password">password</label>
			        <input type="text" class="form-control" name="password" id="password" v-model="form.password">
			        <div class="invalid-feedback" v-if="form.errors.has('password')" v-text="form.errors.get('password')"></div>
			      </div>			  			
				</div>
			</div>
			
			<div class="border border-primary p-3 my-3">
			  <input type="checkbox" name="facturatiegegevens" v-model="form.facturatiegegevens"
			  		v-on:click="vul_facturatie_in">klik als het facturatieadres anders is als het contactpersoon adres</input>

			  <div id="factuur" v-if='form.facturatiegegevens'>
				<div class="form-row">
					<div class="form-group col-md-8">
						<label for="factuur_naam">volledige naam</label>
						<input type="text" class="form-control" placeholder="volledige naam"
							name="factuur_naam" id="factuur_naam" v-model="form.factuur_naam">
						<div class="invalid-feedback d-block" v-if="form.errors.has('factuur_naam')" 
							v-text="form.errors.get('factuur_naam')"></div>
					</div>
				</div>

			    <div class="form-row">
			      <div class="form-group col-md-10">
			        <label for="factuur_straat">factuur_straat</label>
			        <input type="text" class="form-control" name="factuur_straat" id="factuur_straat" v-model="form.factuur_straat">
			        <div class="invalid-feedback" v-if="form.errors.has('factuur_straat')" v-text="form.errors.get('factuur_straat')"></div>
			      </div>
			
			      <div class="form-group col-md-2">
			        <label for="factuur_huisnummer">factuur_huisnummer</label>
			        <input type="text" class="form-control" name="factuur_huisnummer" id="factuur_huisnummer" v-model="form.factuur_huisnummer">
			        <div class="invalid-feedback" v-if="form.errors.has('factuur_huisnummer')" v-text="form.errors.get('factuur_huisnummer')"></div>
			      </div>
			    </div>
			
			    <div class="form-row">
			      <div class="form-group col-md-3">
			        <label for="factuur_bus">factuur_bus</label>
			        <input type="text" class="form-control" name="factuur_bus" id="factuur_bus" v-model="form.factuur_bus">
			        <div class="invalid-feedback" v-if="form.errors.has('factuur_bus')" v-text="form.errors.get('factuur_bus')"></div>
			      </div>
			
			      <div class="form-group col-md-3">
			        <label for="factuur_postcode">factuur_postcode</label>
			        <input type="text" class="form-control" name="factuur_postcode" id="factuur_postcode" v-model="form.factuur_postcode">
			        <div class="invalid-feedback" v-if="form.errors.has('factuur_postcode')" v-text="form.errors.get('factuur_postcode')"></div>
			      </div>
			
			      <div class="form-group col-md-5">
			        <label for="factuur_gemeente">factuur_gemeente</label>
			        <input type="text" class="form-control" name="factuur_gemeente" id="factuur_gemeente" v-model="form.factuur_gemeente">
			        <div class="invalid-feedback" v-if="form.errors.has('factuur_gemeente')" v-text="form.errors.get('factuur_gemeente')"></div>
			      </div>
			    </div>
			
			    <div class="form-row">
			      <div class="form-group col-md-6">
			        <label for="factuur_email">factuur_email</label>
			        <input type="text" class="form-control" name="factuur_email" id="factuur_email" v-model="form.factuur_email">
			        <div class="invalid-feedback" v-if="form.errors.has('factuur_email')" v-text="form.errors.get('factuur_email')"></div>
			      </div>		
			    </div>				
				
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
  		     this.form.straat = this.form.contactpersoon_straat;
  		     this.form.huisnummer = this.form.contactpersoon_huisnummer;
  		     this.form.bus = this.form.contactpersoon_bus;
  		     this.form.postcode = this.form.contactpersoon_postcode;
  		     this.form.gemeente = this.form.contactpersoon_gemeente;
  		     this.form.telefoon = this.form.contactpersoon_telefoon;
  		     this.form.gsm = this.form.contactpersoon_gsm;
  		     this.form.email = this.form.contactpersoon_email;
/*  		     this.form. = this.form.contactpersoon_;
  		     this.form. = this.form.contactpersoon_;
*/
			   
		  } else {
		  	 this.form.voornaam = "";
		  	 this.form.familienaam = "";
		  	 this.form.straat = "";
		  	 this.form.huisnummer = "";
		  	 this.form.bus = "";
		  	 this.form.postcode = "";
		  	 this.form.gemeente = "";
		  	 this.form.telefoon = "";
		  	 this.form.gsm = "";
		  	 this.form.email = "";
/*		  	 this.form. = "";
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

