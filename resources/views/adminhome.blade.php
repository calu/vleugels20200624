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
               	'href' => '/clients',
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
		
		<div class="col md-4">
			<?php
				$info = [
					'header' => 'Mutualiteiten',
					'icon' => 'fa-folder-open',
					'text' => 'Overzicht van de mutualiteiten. Je kan de bestaande
					editeren, wissen en ook een nieuwe bijvoegen',
					'button' => 'mutualiteit',
					'href' => '/mutualiteiten',
					'aantal' => 0	
				];
			?>
			@include('admin.partials.card', $info)
		</div>
 	</div>
	<div class="row">
		<div class="col md-4">
			<?php
				$info = [
					'header' => 'Codes',
					'icon' => 'fa-euro-sign',
					'text' => 'Overzicht van de codes voor het bepalen van de kamerprijs',
					'button' => 'code',
					'href' => '/codes',
					'aantal' => 0	
				];
			?>
			@include('admin.partials.card', $info)
		</div>		
		
		<div class="col md-4">
			<?php
				$info = [
					'header' => 'Kamers',
					'icon' => 'fa-home',
					'text' => 'Hier kan je de kamers bewerken. Let wel : wijzig geen kamer als er diensten geprogrammeerd staan.',
					'button' => 'kamers',
					'href' => '/kamers',
					'aantal' => 0	
				];
			?>
			@include('admin.partials.card', $info)
		</div>	
		
		<div class="col md-4">
			<?php
				$aantal_aanvragen = App\Hotel::all()->where('status','aangevraagd')->count();
				$info = [
					'header' => 'Boekhouding',
					'icon' => 'fa-paperclip',
					'text' => 'de boekhouding gebeurt hier',
					'button' => 'boekhouding',
					'href' => '/boekhouding',
					'aantal' => $aantal_aanvragen
				];
			?>
			@include('admin.partials.card', $info)
		</div>			
				
	</div>
	
	<div class="row">
		<div class="col md-4">
			<?php
				$info = [
					'header' => 'Algemeen',
					'icon' => 'fa-globe',
					'text' => 'Algemene gegevens worden in dit onderdeel ingevuld of aangevuld',
					'button' => 'algemeen',
					'href' => '/algemeen',
					'aantal' => 0	
				];
			?>
			@include('admin.partials.card', $info)
		</div>	
		
		<div class="col md-4">
			<?php
				$info = [
					'header' => 'Vraagtypes',
					'icon' => 'fa-question',
					'text' => 'Vul hier de vragentypes bij',
					'button' => 'vraagtype',
					'href' => '/vragentype',
					'aantal' => 0	
				];
			?>
			@include('admin.partials.card', $info)
		</div>	
		
		<div class="col md-4">
			<?php
				$aantal_onbeantwoorde_vragen = App\Vraag::all()->where('status','aangevraagd')->count();
								
				$info = [
					'header' => 'Vragen van klanten',
					'icon' => 'fa-question',
					'text' => 'Je krijgt een overzicht van alle vagen (beantwoord of niet) en krijgt de gelegenheid om een antwoord te sturen',
					'button' => 'overzicht en beantwoord vragen',
					'href' => '/vraag',
					'aantal' => $aantal_onbeantwoorde_vragen
				];
			?>
			@include('admin.partials.card', $info)
		</div>							
	</div>

	
	<div class="row">	
		<div class="col md-4">
			<?php
				
				$aantal_aanvragen = App\Wijzig::all()->count();
								
				$info = [
					'header' => 'aanvraag wijziging/annulatie',
					'icon' => 'fa-handshake',
					'text' => 'Een overzicht van alle aanvragen voor wijziging of annulatie voor overnachtingen, met mogelijkheid tot wijziging',
					'button' => 'overzicht en beantwoord vragen',
					'href' => '/wijzig/adminwijzig',
					'aantal' => $aantal_aanvragen
				];
			?>
			@include('admin.partials.card', $info) 
		</div>							
	</div>
	
	<div class="row">	
		<div class="col md-4">
			<?php				
				$info = [
					'header' => 'TEST',
					'icon' => 'fa-handshake',
					'text' => 'een test',
					'button' => 'test',
					'href' => '/testen',
					'aantal' => 0
				];
			?>
			@include('admin.partials.card', $info)
		</div>							
	</div>	
</div>
@endsection
