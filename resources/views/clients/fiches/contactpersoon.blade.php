<?php
  $info = [];
  $info['client_id'] = $client->id;
  $info['id'] = $contactpersoon->id;
  $info['voornaam'] = $contactpersoon->voornaam;
  $info['familienaam'] = $contactpersoon->familienaam;   
  $info['relatie'] = $contactpersoon->relatie;  
  $info['straat'] = $contactpersoon->straat;  
  $info['huisnummer'] = $contactpersoon->huisnummer; 
  $info['bus'] = $contactpersoon->bus;  
  $info['postcode'] = $contactpersoon->postcode;  
  $info['gemeente'] = $contactpersoon->gemeente;  
  $info['telefoon'] = $contactpersoon->telefoon;  
  $info['gsm'] = $contactpersoon->gsm;  
  $info['email'] = $contactpersoon->email;  
  $info['rubriek'] = $contactpersoon->rubriek;  
  $info['vraag'] = $contactpersoon->vraag;  
  $info['openstaand'] = $contactpersoon->openstaand;    
?>


<section class="resume-section col-12" id="Contactpersoon">    
  <div class="card">
     <h2 class="card-title text-primary text-center">De contactpersoon</h2>
     <contactpersoon @completed="vermelden" 
        :data="{{ json_encode($info) }}"
     ></contactpersoon>
  </div>
</section>