<!-- in dit onderdeel voegen we een drukknop toe om het item te editeren -->
<!-- als dit de admin is -->
@if( \Auth::User()->isAdmin())
  <!-- maak nu een knop die verwijst naar de editpagina voor dit onderdeel -->
  <a href="{{ $url }}" class="btn btn-rounded btn-primary">wijzig</a>
<!-- anders, als dit de klant is -->
@elseif( !auth()->guest() )
    <p>TODO : spring naar een fiche waarin dan de klant gevraagd wordt 
      naar extra info en dat wordt dan gemaild naar 'vleugels'
    </p>
@endif