<div>
	<p>Beste info,</p>
	<br /><br />
	<p>Zopas heb je een annulatie/wijziging aanvraag behandelt.</p>
	
	<p>Je hebt de aanvraag {{ $info['status']}}</p> <!-- aanvoord of geweigerd -->
	@if ($info['status'] == 'geweigerd')
	  <p>Er wordt dus verder niets veranderd</p>
	@else
	  <p>Je hebt een {{ $info['rubriek'] }} aanvaard</p>
	  <p>Je moet nu eventueel ook de factuur aanpassen.</p>
	  <p>Klik daarvoor op de tab 'Factuur'</p>
	@endif
	<hr />
	<p>Met vriendelijke groeten</p>
	<p>de website beheerder</p>
</div>