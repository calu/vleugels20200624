<!DOCTYPE html>
<html>
	<head>
		<title>factuur in PDF formaat</title>
		
		<style>
			p.factuurdata {
				margin-top : 0%;
				margin-bottom : 0%;
			}
			
			.tabel {
				border : 1px solid black;
				width : 100%;
			}
			
			
			#totaal {
				border : 1px solid black;
				width : 30%;
				position : absolute; right : 0%;
				margin : 8px;
			}
			
			#betaling {
				position : static;
				width : 100%;
				margin : 30px;
			}
		</style>
	</head>
	<body>
		<table style="width : 100%">
			<tr>
				<td style="width : 30%"><img src="img/logovleugels.png" class="rounded float-left" alt="..."></td>
				<td style="font-size : 10px">Erkend en gesubsidieerd door het Vlaams Agentschap
						voor Personen met een Handicap</td>
				<td><img src="img/VAPH-logo.png" class="rounded float-right" width="50px" /></td>
			</tr>
		</table>
		
		<!-- adres rechts gealigneerd -->
		<div style="position : absolute; left : 400px; align : right">
			<p class="factuurdata">{{ $factuur_naam ?? '' }}</p>
			<p class="factuurdata">{{ $factuur_straat}}, {{ $factuur_huisnummer}} &nbsp; {{ $factuur_bus }}</p>
			<p class="factuurdata">{{ $factuur_postcode }}&nbsp;&nbsp;{{ $factuur_gemeente }}</p>
		</div>

		<div  style="position : absolute; top : 20%; left : 20px">
			<p class="factuurdata" style="font-size : 25px">Factuur</p>
			<p class="factuurdata">Factuurnr : {{ $factuur_jaar }}/{{ $factuur_volgnummer }}</p>
			<p class="factuurdata">Datum : {{ $factuur_datum }}</p>
			<p class="factuurdata">BTW : ik dacht dat je dat niet had?</p>
		</div>	

		<div style="position : absolute; top : 30%">
		  <table class="tabel">
			  <tr>
				  <th style="width : 60%">Omschrijving</th>
				  <th>Aantal</th>
				  <th>Prijs</th>
				  <th>Totaal</th>
			  </tr>
			  
			  @php $totaal = 0; @endphp
			  @foreach ( $hotels as $hotel)
			    @php 
				//   dd($hotel);
				  $totaal += $hotel['bedrag'];
				@endphp
			  	<tr>
					  <td>Verblijf in hotel van {{ $hotel['begindatum'] }} tot {{ $hotel['einddatum'] }}</td>
					  <td>1</td>
					  <td></td>
					  <td>{{ $hotel['bedrag'] }}</td>
			    </tr>
			  @endforeach
		  </table>

		  <table  id="totaal">
			  <tr><td> {{ $totaal }} </td></tr>
		  </table>
		  
		  <table id="betaling">
			  <tr>
			  	<td>Gelieve bovenstaand bedrag te storten op rekening {{ $vleugels_iban }}. Dank u bij voorbaat</td>
		  	  </tr>
			  <tr>
				  <td style="font-size : 10px">Onze voorziening is geen BTW-plichtige: art. 44 par 2.1</td>
			  </tr>
		</table>
	  </div>
	  
<div style="position : absolute; bottom : 7%; width : 100%">
	<hr />
	<p>{{ $vleugels_afzenderstraatennummer }} &bull; {{ $vleugels_afzenderZipenGemeente }} &bull; tel : {{ $vleugels_afzenderTelefoon }} &bull; mail : {{ $vleugels_afzenderEmail}}</p>
	<p>IBAN {{ $vleugels_iban }} &bull; BIC {{ $vleugels_bic}} &bull; www.devleugels.be &bull; BE0431.408.290</p>
</div>	  
	</body>
</html>
