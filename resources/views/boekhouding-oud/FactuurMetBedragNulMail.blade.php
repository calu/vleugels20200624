<!DOCTYPE html>
@php
$data = $info['data'];
$client = $info['client'];
@endphp
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
	<p>Beste boekhouder,</p>
	<br />
	<p>Onlangs heb je een aangevraagde reservatie bevestigd. Echter is het bedrag nog niet ingevuld.</p>
	<p>Daarom hebben we reeds een factuur aangemaakt, maar met bedrag = 0. Je zal merken dat we deze
		factuur nog steeds als "aangevraagd" gemerkt gelaten. (Bij de boekhouding).</p>
	<p>Klik dus op deze factuur in boekhouding en vul het bedrag in, om het definitief als toegekend
		te merken, en de facturen te sturen naar jou en naar de contactpersoon (als hij een e-mail adres heeft opgegeven)</p>
	<hr />
	<b>de gegevens over deze factuur</b>
	<p><b>factuurnummer</b> : {{ $data['jaar']}}/{{ $data['factuurvolgnummer'] }}</p>
	<p><b>factuurdatum</b> : {{ $data['datum']}}</p>
	<p><b>omschrijving</b> : {{ $data['omschrijving']}}</p>
	<p><b>klant</b> : {{ $client->voornaam}}." ".{{ $client->familienaam }}</p>
	<hr />
	<br />
	<p>veel succes,</p>
	<p>de systeembeheerder</p>
	</body>
</html>