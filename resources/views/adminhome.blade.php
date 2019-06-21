@extends('layouts.vleugelslayout')

@section('content')
<div class="container" id="mijn-card">
	<h1 class="d-flex justify-content-center">Dashboard van de beheerder</h1>
	<div class="row">
		<div class="col md-4">
 		@include(
			'admin.partials.card', 
			[
				'header' => 'klanten', 
               	'icon' => 'fa-users',
               	'text' => 'Een overzicht van alle klanten (en admins). Je kan deze editeren, aanvullen of verwijderen',
               	'button' => 'klanten',
               	'href' => '#',
				'aantal' => 0
           	])
		</div>
		
		<div class="col md-4">
			<?php
				$aantal_openstaande_contactpersonen = App\Contactpersoon::all()->where('openstaand', 1)->count();
				
				$info = [
					'header' => 'Contactpersonen',
					'icon' => 'fa-envelope',
					'text' => 'Overzicht van de contactpersonen. 
					     Bij een intake gesprek klik je op de openstaande om te linken aan klant. 
						 Anders kan je alle wissen, editeren of een nieuwe toevoegen',
					'button' => 'contactpersonen',
					'href' => '/contactpersonen',
					'aantal' => $aantal_openstaande_contactpersonen 	
				];
			?>
			@include('admin.partials.card', $info)
		</div>
 	</div>
</div>
@endsection
