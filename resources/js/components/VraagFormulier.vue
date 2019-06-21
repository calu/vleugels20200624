<template>
	<div class="container">
		<div class="jumbotron jumbotron-fluid p-1">
			<p style="font-size : 1.3rem">
			Beste contactpersoon,<br />
			In dit formulier vragen we heel wat persoonlijke gegevens,
			maar we willen je graag contacteren om een intake gesprek
			te hebben. Zo kunnen we beter op je vragen antwoorden.
			</p>
		</div>

	
		<form method="POST" action="/contactpersonen"
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
			
		    <div class="form-row">
		      <div class="form-group col-md-10">
		        <label for="relatie">relatie met klant</label>
		        <input type="text" class="form-control" name="relatie" id="relatie" v-model="form.relatie">
		        <div class="invalid-feedback" v-if="form.errors.has('relatie')" v-text="form.errors.get('relatie')"></div>
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
		
		      <div class="form-group col-md-5">
		        <label for="email">email</label>
		        <input type="text" class="form-control" name="email" id="email" v-model="form.email">
		        <div class="invalid-feedback" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></div>
		      </div>
		    </div>

		    <div class="form-row">
		      <div class="input-group">
		        <div class="input-group-prepend">
		          <span class="input-group-text">Rubriek</span>&nbsp;&nbsp;
		        </div>
		
		        <div class="form-check form-check-inline">
		          <input class="form-check-input" type="radio" name="rubriek" id="rubriek" v-model="form.rubriek" value="hotel">
		          <label class="form-check-label" for="rubriek">hotel</label>
		        </div>
		        <div class="form-check form-check-inline">
		          <input class="form-check-input" type="radio" name="rubriek" id="rubriek" v-model="form.rubriek" value="dagverblijf">
		          <label class="form-check-label" for="rubriek">dagverblijf</label>
		        </div>
		        <div class="form-check form-check-inline">
		          <input class="form-check-input" type="radio" name="rubriek" id="rubriek" v-model="form.rubriek" value="therapie">
		          <label class="form-check-label" for="rubriek">therapie</label>
		        </div>
		      </div>
			  
			  <div class="invalid-feedback" v-if="form.errors.has('rubriek')"
			       v-text="form.errors.get('rubriek')"></div> 
		    </div>
		
		    <div class="form-row">
		      <div class="form-group col-md-12">
		        <label for="vraag">Stel je vraag</label>
		        <textarea class="form-control" rows="5" name="vraag" v-model="form.vraag"></textarea>
		        <div class="invalid-feedback" v-if="form.errors.has('vraag')" v-text="form.errors.get('vraag')"></div>
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
//		console.log("onSubmit : " + this.form.id);
			if ( this.form.id == 0){
				this.form.post('/contactpersonen')
				  .then( data => this.$emit('completed', data))
				  .catch( errors => console.log(errors));
			} else {
				this.form.patch('/contactpersonen/' + this.form.id)
				  .then ( data => this.$emit('completed', data) )
				  .catch( errors => console.log(errors));
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

