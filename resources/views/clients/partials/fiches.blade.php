<?php   
     // dd($contactpersoon); 
    
    $mut = \App\Mutualiteit::findOrFail($client->mutualiteit_id);
    $mutnaam = $mut->naam;
?>
<div class="card">
  <div class="card-body">
    <h2 class="card-title text-white bg-secondary d-flex justify-content-center"><b>Klant</b> : {{ $client->voornaam." ".$client->familienaam }}</h2>
    <div class="card-text">
        <p>
            <b>straat</b> : {{ $client->straat.",".$client->huisnummer }}
        	<?php if (strlen($client->bus) > 0){ echo ('<b>bus : </b>'.$client->bus); } else echo (""); ?>
        <br />
            <b>gemeente : </b> {{ $client->postcode." ".$client->gemeente }}
        </p>
        <p>
            <b>telefoon : </b> {{ $client->telefoon }} <b>gsm :</b> {{ $client->gsm }}
        </p>
        <p>
             <b>geboortedatum :</b> {{ $client->geboortedatum }} &nbsp;
             <b>RijksRegisterNummer :</b>  {{ $client->rrn }}              
        </p>
        <p>
            <b>statuut</b> : {{ \App\Enums\StatuutType::getDescription($client->statuut) }}  &nbsp;
            <b>mutualiteit</b> : {{ $mutnaam }}
        </p>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <h2 class="card-title text-white bg-secondary d-flex justify-content-center">Login gegevens</h2>
    <div class="card-text">
        <p>
           <b>e-mail</b> : {{ $user->email }}
           <br />
           @if (Auth::user()->isAdmin())
              <a href="#" class="btn btn-primary">Wijzig wachtwoord</a> 
           @endif           
        </p>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <h2 class="card-title text-white bg-secondary d-flex justify-content-center"><b>Facturatieadres</b> </h2>
    <div class="card-text">
        <p>
            <b>naam</b> : {{ $client->factuur_naam }}
            <br />
            <b>straat</b> : {{ $client->factuur_straat.",".$client->factuur_huisnummer }}
        	<?php if (strlen($client->factuur_bus) > 0){ echo ('<b>bus : </b>'.$client->factuur_bus); } else echo (""); ?>
        <br />
            <b>gemeente : </b> {{ $client->factuur_postcode." ".$client->factuur_gemeente }}
        </p>
        <p>
            <b>email : </b> {{ $client->factuur_email }}
        </p>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <h2 class="card-title text-white bg-secondary d-flex justify-content-center"><b>Contactpersoon</b> : {{ $client->voornaam." ".$client->familienaam }}</h2>
    <div class="card-text">
        <p>
            <b>relatie met klant</b> {{ $contactpersoon->relatie }}
            <br />
            <b>straat</b> : {{ $contactpersoon->straat.",".$contactpersoon->huisnummer }}
        	<?php if (strlen($contactpersoon->bus) > 0){ echo ('<b>bus : </b>'.$contactpersoon->bus); } else echo (""); ?>
        <br />
            <b>gemeente : </b> {{ $contactpersoon->postcode." ".$contactpersoon->gemeente }}
        </p>
        <p>
            <b>telefoon : </b> {{ $contactpersoon->telefoon }} <b>gsm :</b> {{ $contactpersoon->gsm }}
        </p>
        <p>
            <b>e-mail</b> : {{ $contactpersoon->email}}
        </p>
        <p>
            <b>de rubriek waarvoor contactpersoon gekozen heeft : </b> {{ $contactpersoon->rubriek }}
            <br />
            <b>de vraag die contactpersoon gesteld heeft</b> : {{ $contactpersoon->vraag }}
        </p>
    </div>
  </div>
</div>
 