
<p>factuurview</p>
<p>klant = {{ $info['client_id'] }}</p>
<p>factuur_naam = {{ $info['factuur_naam']}}</p>
<p>factuur_huisnummer = {{ $info['factuur_huisnummer'] }}</p>
<p>factuur_bus = {{ $info['factuur_bus'] }}</p>
<p>factuur_postcode = {{ $info['factuur_postcode'] }}</p>
<p>factuur_gemeente = {{ $info['factuur_gemeente'] }}</p>
<p>factuur_email = {{ $info['factuur_email'] }}</p>
<p>vleugels_afzendernaam = {{ $info['vleugels_afzendernaam'] }}</p>
<p>vleugels_afzenderstraatennummer = {{ $info['vleugels_afzenderstraatennummer'] }}</p>
<p>vleugels_afzenderZipenGemeente = {{ $info['vleugels_afzenderZipenGemeente'] }}</p>
<p>vleugels_afzenderTelefoon = {{ $info['vleugels_afzenderTelefoon'] }}</p>
<p>vleugels_afzenderEmail = {{ $info['vleugels_afzenderEmail'] }}</p>
<p>vleugels_iban = {{ $info['vleugels_iban'] }}</p>
<p>vleugels_bic = {{ $info['vleugels_bic'] }}</p>
<p>factuur_volgnummer = {{ $info['factuur_volgnummer'] }}</p>
<p>factuur_datum = {{ $info['factuur_datum'] }}</p>

@foreach ($info['hotels'] as $hotel)
	<p>{{ $hotel['hotel_id'] }} {{ $hotel['begindatum'] }} {{ $hotel['einddatum'] }} {{ $hotel['kamernummer'] }} {{ $hotel['bedrag'] }}</p>
@endforeach


 