<!-- in dit onderdeel zullen we enkel een prijs tonen als
  1. DE kamer beschikbaar is ( bij de keuze worden enkel deze getoond)
  2. de klant is aangemeld (of als het de admin is)
  3. Deze werd aangevraagd ( $choice = true )
-->
@if ( $choice && \Auth::check())
<h1 class="price">
	<i class="fa fa-euro"></i>
		berekende prijs ....
	<span>/nacht</span>
</h1>
@else
<div>
	<h1 class="price" >prijs</h1>
</div>
@endif