<?php
	$info = [];
  $info['client_id'] = $client->id;
	$info['voornaam'] = $client->voornaam;
  $info['familienaam'] = $client->familienaam;
  $info['straat'] = $client->straat;
  $info['huisnummer'] = $client->huisnummer;
  $info['bus'] = $client->bus;   
  $info['postcode'] = $client->postcode;
  $info['gemeente'] = $client->gemeente; 
  $info['telefoon'] = $client->telefoon;
  $info['gsm'] = $client->gsm;
  $info['geboortedatum'] = $client->geboortedatum;
  $info['rrn'] = $client->rrn;
  $info['mutualiteit_id'] = $client->mutualiteit_id;
  // TODO mutualiteit naam
  $mutualiteit = DB::table('mutualiteits')->find($client->mutualiteit_id)->naam;
  $info['mutualiteit'] = $mutualiteit;
  // hier geen factuurgegevens
  $statuutnaam = App\Enums\StatuutType::getDescription($client->statuut);
  $info['statuut_id'] = $client->statuut;
  $info['statuut'] = $statuutnaam;      
  
  // We voegen ook de mutgegevens toe
  $mutualiteit = DB::table('mutualiteits')->get()->all();
  $mut = [];
  foreach ($mutualiteit as $element){
    $mut[] =$element;
  }
  
  // DE verschillende statuten opvragen
  $statuten = App\Enums\StatuutType::getKeys();
  
?>
<section class="resume-section col-12" id="about">    
  <div class="card">
     <h2 class="card-title text-primary text-center">Klantgegevens</h2>
     <klantgegevens @completed="vermelden" 
           :data="{{ json_encode($info) }}" 
           :mut="{{ json_encode($mut) }}"
           :statuten = "{{ json_encode($statuten) }}"></klantgegevens>
  </div>
</section>
	

