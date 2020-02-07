<div>
@if ( $info['gevonden'])
<p>Geachte heer/mevrouw {{ $info['voornaam'] }} {{ $info['familienaam']}}</p>
<br />
<p>Zopas ontvingen we een melding van {{ $info['email'] }} dat het wachtwoord vergeten is.</p>
<p>Je kan nu een nieuw wachtwoord invoeren door op de onderstaande link te klikken</p>
<br />
<a href="wachtwoord/reset/{{ $info['token']}}">klik hier</>
@else
  <p>Beste sys_admin,</p><br />
  Er werd gepoogd een wachtwoord te resetten en er werd als klant e-mail de volgende 
  waarde ingevuld : {{ $info['email']}}.
  
  Als dit het e-mail adres van een Contactpersoon zou zijn, misschien kan je
  hem dan contacteren, want enkel de e-mail (fake) van de klanten worden aanvaard
  om aan te melden.
  
  
@endif	
</div> 