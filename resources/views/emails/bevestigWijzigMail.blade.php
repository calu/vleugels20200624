<div>
	<p>Beste {{ $info['contactpersoon_vollenaam'] }},</p>
	<br />
	<p>Zopas hebben we de door u aangevraagde wijziging aangebracht.</p>
	<p>uw aanvraag was</p>
	<hr />
	<p>{{ $info['wijzigaanvraag']}}
	<hr />
	<br />
	<p>Om volledig te zijn, geven we ook wat extra info:</p>
	<p>naam klant : {{ $info['client_vollenaam'] }}</p>
	<p>oorspronkelijke data : {{ $info['oorspronkelijkedata']}} </p>
	<br />
	<p>De huidige situatie is dus :</p>
	<p>verblijf van {{ $info['begindatum'] }} tot {{ $info['einddatum']}}</p>
	<p>kamernummer : {{ $info['kamernummer']}}</p>
	<p>prijs : {{ $info['bedrag']}}</p>
	<br />
	<p>Indien u nog vragen hebt, dan kan je gerust contact opnemen</p>
	<br />
	<p>met vriendelijke groeten</p>
	<p>vzw de vleugels</p>
	<p>{{ $info['vleugels_adres1']}}</p>
	<p>{{ $info['vleugels_adres2']}}</p>
	<p>tel : {{ $info['vleugels_telefoon']}}</p>
	<p>email : {{ $info['vleugels_email']}}</p>
</div>