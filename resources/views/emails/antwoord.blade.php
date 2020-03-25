<div>
	<p>Geachte Mevr/Meneer {{ $info['contactpersoonnaam']}},</p>
	<br />
	<p>Op {{ $info['vraagdatum'] }} ontvingen we een vraag van {{ $info['klantnaam'] }} met als
		inhoud</p>
	<p>---------</p>
	<p>{{ $info['vraag'] }}</p>
	<p>---------</p>
	<p>Ons antwoord op deze vraag is :</p>
	<p>{{ $info['antwoord'] }}</p>
	<br/>
	<p>We hopen u hiermee geholpen te hebben, maar in het geval dit antwoord uw vraag niet
		beantwoordt, kan u nog altijd een nieuwe vraag stellen, of contact opnemen met ons:</p>
    <p>tel : {{ $info['vleugelstelefoon'] }}</p>
</div>