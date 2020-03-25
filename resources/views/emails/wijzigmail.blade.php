<div>
	<p>Beste info,</p>
	<br />
	<p>Een wijzigingsaanvraag voor een overnachting werd zopas verstuurd voor {{ $info["klantVolleNaam"] }}</p>
	<p>De oorspronkelijke periode is van {{ $info["begindatum"] }} tot {{ $info["einddatum"] }}</p>
	<p>De vraag is :</p>
	<p>------</p>
	<p>{{ $info["wijzigingvraag"]  }}
	<p>------</p>
	<p> nog wat info : </p>
	<p>  contact : {{ $info["contactVolleNaam"]  }}</p>
	<p>  e-mail : {{ $info["contactEmail"]  }}</p>
	<p>  adres : {{ $info["adres1"]  }}</p>
	<p>  adres : {{ $info["adres2"]  }}</p>
	<p>  telefoon : {{ $info["telefoon"] }}</p>
	<p>  gsm : {{ $info["gsm"] }} </p>
	<br />
	<p>Om de wijzigingen aan te brengen of te verwijderen ga naar de website en meld je aan als admin</p>
	<p>Vervolgens kies je</p>
	<ul>
		<li>klanten : en kies daar de klant / vervolgens "aanmelden" en dan "toon"</li>
		<li>aanvraag wijziging/annulatie : 
			<br />kies de reservatie met periode {{ $info["begindatum"] }} tot {{ $info["einddatum"] }}
			<br />en daar druk je op "aanpassen"
		</li>
	</ul>
	
</div>
