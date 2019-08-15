<template>
	<div class="container">
       <h1 class="d-flex justify-content-center">Kamergegevens aanpassen</h1>

		<form method="POST" action="/kamers"
			  @submit.prevent="onSubmit"
			  @keydown="form.errors.clear($event.target.name)">
			
			<!-- kamernummer aantal bedden en soort-->  
			<div class="form-row">
				<div class="form-group col-md-3">
					<label for="kamernummer">kamernummer</label>
					<input type="text" class="form-control" placeholder="kamernummer"
						name="kamernummer" id="kamernummer" v-model="form.kamernummer">
					<div class="invalid-feedback d-block" v-if="form.errors.has('kamernummer')" 
						v-text="form.errors.get('kamernummer')"></div>
				</div>
				
				<div class="form-group col-md-3">
					<label for="aantal_bedden">aantal bedden</label>
					<input type="text" class="form-control" placeholder="aantal_bedden"
						name="aantal_bedden" id="aantal_bedden" v-model="form.aantal_bedden">
					<div class="invalid-feedback d-block" v-if="form.errors.has('aantal_bedden')" 
						v-text="form.errors.get('aantal_bedden')"></div>
				</div>	

				<div class="form-group col-md-3">
					<label for="soort">soort</label>
					<input type="text" class="form-control" placeholder="soort"
						name="soort" id="soort" v-model="form.soort">
					<div class="invalid-feedback d-block" v-if="form.errors.has('soort')" 
						v-text="form.errors.get('soort')"></div> 
				</div>	
			</div>
			
			<!-- omschrijving -->
			<div class="form-row">
				<div class="form-group col-md-12">
					<label for="beschrijving">beschrijving</label>
					<textarea type="text" class="form-control" placeholder="beschrijving"
						name="beschrijving" id="beschrijving" v-model="form.beschrijving"></textarea>
					<div class="invalid-feedback d-block" v-if="form.errors.has('beschrijving')" 
						v-text="form.errors.get('beschrijving')"></div>
				</div>				
			</div>
			
			<!-- foto -->
			<div class="form-row">
			   <div class="form-group col-md-12"> 
			   		<file-upload @fotobestand="kopieerfotobestand"></file-upload>
			   </div>
			   <!-- div class="form-group col-md-6">
				   <label for="foto">foto</label>
				   <input type="text" class="form-control" placeholder="foto" name="foto"
		 		      id="foto" v-model="form.foto"></input>
			  </div>
			  -->
			  <!--
			  <input type="hidden" name="foto" v-model="form.foto" value="kamer101.png" /> 
			  -->
			   <p style="color:green"><b>in de toekomst hier misschien foto's opladen ...</b></p>
			   <br />
			   <div v-if="form.foto !== ''">
				   <img :src="'/img/hotelkamers/' + form.foto" />
			   </div>

			</div>
		
		    <!--div class="control">
		    < !-- de ':disabled="form.errors.any()"' werd weggelaten omdat er problemen
		         zijn als je de telefoon niet invult en daarna wel, maar geen gsm.
		         Je zou moeten ook een spatie in de gsm intikken om te werken.
		         Dit is zeer gebruikersonvriendelijk en wordt daarom weggelaten -- >
		        <button class="button is-primary" >Verzend</button>
		    </div -->
			
			<div class="form-row">
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
				this.form.post('/kamers')
//				  .then( data => this.$emit('completed', data))
				  .then( data => this.spring(data.message))
				  .catch( errors => console.log(errors));
			} else {
				this.form.patch('/kamers/' + this.form.id)
//				  .then ( data => this.$emit('completed', data) )
                  .then ( data => this.spring(data.message))
				  .catch( errors => console.log(errors));
			}
		}, 
		
		spring(data){ 
		    var $url = "https://" + window.location.hostname + "/" + data;
			window.location=$url;	
		},
		
		kopieerfotobestand(data){
			this.form.foto = data;
		}
	},
}
</script>

<style scoped>
.invalid-feedback{
   display: block;
}
</style>

