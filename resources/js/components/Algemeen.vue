<template>
	<div class="col-12 grid-margin">
		<div class="cord">
			<div class="cord-body">
				<h2 class="card-title text-center">De facturatiegegevens</h2>   
				<p />
				
				<form class="form-sample" method="POST" action="/algemeen"
              		@submit.prevent="onSubmit"
              		@keydown="form.errors.clear($event.target.name)">
					  
					<div class="row">
						<h3 class="col text-center text-bold">
							De bankgegevens voor de factuur
						</h3>
					</div>
					
					<div class="row">
						<div class="col-md-4">
							<label for="banknaam">Naam van de bank</label>
							<input type="text" class="form-control" id="banknaam"
								name="banknaam" v-model="form.banknaam" />
							<div class="invalid-feedback d-block" 
							   v-if="form.errors.has('banknaam')"
							   v-text="form.errors.get('banknaam')">
							</div>
						</div>
	
						<div class="col-md-4">
							<label for="iban">IBAN</label>
							<input type="text" class="form-control" id="iban"
								name="iban" v-model="form.iban" />
							<div class="invalid-feedback d-block" 
							   v-if="form.errors.has('iban')"
							   v-text="form.errors.get('iban')"> 
							</div>
						</div>
	
						<div class="col-md-4">
							<label for="bic">BIC</label>
							<input type="text" class="form-control" id="bic"
								name="bic" v-model="form.bic" />
							<div class="invalid-feedback d-block" 
							   v-if="form.errors.has('bic')"
							   v-text="form.errors.get('bic')"> 
							</div>
						</div>						
					</div>
					
					<div class="row">
						<h3 class="col text-center text-bold">
						Adres, telefoon en e-mail van afzender
						</h3>
					</div>
					
					<div class="row">
						<div class="col">
							<label for="factuur_afzendernaam">afzender naam</label>
							<input type="text" class="form-control" id="factuur_afzendernaam"
								name="factuur_afzendernaam" v-model="form.factuur_afzendernaam" />
							<div class="invalid-feedback d-block" 
							   v-if="form.errors.has('factuur_afzendernaam')"
							   v-text="form.errors.get('factuur_afzendernaam')"> 	
							</div>						
						</div>
					</div>
					
					<div class="row">
						<div class="col">
							<label for="factuur_afzenderstraatennummer">afzender straat en nummer</label>
							<input type="text" class="form-control" id="factuur_afzenderstraatennummer"
								name="factuur_afzenderstraatennummer" v-model="form.factuur_afzenderstraatennummer" />
							<div class="invalid-feedback d-block" 
							   v-if="form.errors.has('factuur_afzenderstraatennummer')"
							   v-text="form.errors.get('factuur_afzenderstraatennummer')"> 	
							</div>						
						</div>
					</div>			
					
					<div class="row">
						<div class="col">
							<label for="factuur_afzenderZipenGemeente">afzender postcode en gemeente</label>
							<input type="text" class="form-control" id="factuur_afzenderZipenGemeente"
								name="factuur_afzenderZipenGemeente" v-model="form.factuur_afzenderZipenGemeente" />
							<div class="invalid-feedback d-block" 
							   v-if="form.errors.has('factuur_afzenderZipenGemeente')"
							   v-text="form.errors.get('factuur_afzenderZipenGemeente')"> 	
							</div>						
						</div>
					</div>		
					
					<div class="row">
						<div class="col-md-6">
							<label for="factuur_afzenderTelefoon">Telefoon</label>
							<input type="text" class="form-control" id="factuur_afzenderTelefoon"
								name="factuur_afzenderTelefoon" v-model="form.factuur_afzenderTelefoon" />
							<div class="invalid-feedback d-block" 
							   v-if="form.errors.has('factuur_afzenderTelefoon')"
							   v-text="form.errors.get('factuur_afzenderTelefoon')">
							</div>
						</div>
	
						<div class="col-md-6">
							<label for="factuur_afzenderEmail">e-mail</label>
							<input type="text" class="form-control" id="factuur_afzenderEmail"
								name="factuur_afzenderEmail" v-model="form.factuur_afzenderEmail" />
							<div class="invalid-feedback d-block" 
							   v-if="form.errors.has('factuur_afzenderEmail')"
							   v-text="form.errors.get('factuur_afzenderEmail')"> 
							</div> 
						</div>					
					</div>
					
					<div class="row">
						<h3 class="col text-center text-bold">
						e-mail adressen voor intern gebruik
						</h3>
					</div>		
								
					<div class="row">
						<div class="col-md-4">
							<label for="sysadmin_email">e-mail van de sys_admin</label>
							<input type="text" class="form-control" id="sysadmin_email"
								name="sysadmin_email" v-model="form.sysadmin_email" />
							<div class="invalid-feedback d-block" 
							   v-if="form.errors.has('sysadmin_email')"
							   v-text="form.errors.get('sysadmin_email')">
							</div>
						</div>
						
					</div>		
																							
					<div class="row">
						<div class="col control">
							<button class="btn btn-primary">Verzend</button>							
						</div><!-- col -->
					</div><!-- row -->					  
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
		}
	},
	
	methods:{
		CalcForm(){
		  // console.log("CalcForm - data = " + this.data);
			return new Form(this.data);
		},
		
		onSubmit(){
			/* console.log("boekhouding onSubmit");
			throw new Error("geen fout, enkel stoppen"); */
			
			this.form.post('/algemeen')
			//	.then( data => this.$emit('completed', data))
				.then( data => this.spring(data.message)) 
				.catch(errors => console.log(errors));
		},
		
		
		spring(data){
		/*	console.log("spring : " + data);
			throw new Error("geen fout, maar stop"); */
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