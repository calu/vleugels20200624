<?php  // dd($kamer); ?>
<div class="container border border-secondary p-3">
	<div class="card" style="width:100%">
		 <img src="/img/hotelkamers/{{ $kamer->foto }}" class="card-img-top" alt="foto van kamer.">
		  <div class="card-body">
		    <p>
				<b>kamernummer</b> : {{ $kamer->kamernummer }}
				<br />
				<b>aantal bedden</b> : {{ $kamer->aantal_bedden }}
				<br />
				<b>soort</b> : {{ $kamer->soort }}
				<br />
				<b>beschrijving</> : {{ $kamer->beschrijving }}
			</p>
		  </div>			 
	</div>
</div>