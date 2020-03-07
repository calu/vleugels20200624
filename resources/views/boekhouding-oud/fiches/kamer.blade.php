<section id="kamer-section">

<div class="col-12 grid-margin">
		<div class="cord">
			<h4 class="card-title">De kamergegevens</h4>
				
			<p class="card-description">enkel ter controler</p>

				<div class="container border border-secondary p-3">
					<div class="card" style="width:100%">
						 <img src="/img/hotelkamers/{{ $info['kamer_foto'] }}" class="card-img-top" alt="foto van kamer.">
						  <div class="card-body">
						    <p>
								<b>kamernummer</b> : {{ $info['kamernummer'] }}
								<br />
								<b>aantal bedden</b> : {{ $info['aantal_bedden'] }}
								<br />
								<b>soort</b> : {{ $info['kamer_soort'] }}
								<br />
								<b>beschrijving</> : {{ $info['kamer_beschrijving'] }}
							</p>
						  </div>			 
					</div>
				</div>

		</div><!-- cord -->
	</div><!-- col-12 -->




	
</section>