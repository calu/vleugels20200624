<section class="container border border-primary mt-2">
	<div class="row align-items-center">
		<div class="col-lg-6">
			<div class="room_left">
				<?php $foto = "img/hotelkamers/".$kamer->foto; ?>
				<img class="img-fluid mx-auto" src="{{ asset($foto)}}" alt="">
			</div>
		</div>
		
		<div class="col-lg-6">
			<!--div class="owl-carousel owl-room" -->
			<div class="room_right">
				@include('kamers.partials.prijs')
				<h1 class="type">
					Kamer {{ $kamer->kamernummer }}
				</h1>
				<p>{{ $kamer->beschrijving }}</p>
				<p>aantal bedden : {{ $kamer->aantal_bedden }}	
				@if ($choice)
					<p>hier het boekingformulier</p>
				@else
					@if (auth()->guest())
						@include('partials.steljevraag')
					@else 
						<a class="btn btn-primary" 
						   href="#beschikbaarheid" 
						   role="button">bekijk beschikbaarheid</a>
					@endif
				@endif								
			</div>
		</div>		
	</div>
</section>
