@php
// We halen alle facturen van deze gebruiker op.
//   in factuur.blade.php hebben we reeds de koppels <serviceable_id, serviceable_type> voorhanden
//     in koppels. 
// dd($koppels);
// We doorlopen nu de koppels en zoeken de overeenkomende entries in tabel factuurs
$facturen = [];
foreach ($koppels as $koppel)
{
	$result = DB::table('factuurs')
	   ->where([
	   	['serviceable_id', $koppel->serviceable_id],
		['serviceable_type', $koppel->serviceable_type],
	   ])->get()->first();
	if (!empty($result)){
		$jaarnummer = array( 'jaar' => $result->jaar, 'factuurvolgnummer' => $result->factuurvolgnummer);
		$facturen[] = $jaarnummer;
	}
}
// verwijder alle dubbele entries
$factuniek = array_unique($facturen);
// dd($factuniek);
@endphp
<div class="col-12 grid-margin">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title">De reeds verstuurde Facturen</h4>  
			<table class="table">
				<thead>
					<th scope="col">Jaar</th>
					<th scope="col">factuurnummer</th>
					<th scope="col"></th>
				</thead>
				<tbody> 
				  @foreach($factuniek as $fact)
				  <tr>
				    <td>{{ $fact['jaar'] }}</td>
				    <td>{{ $fact['factuurvolgnummer']}}</td>
					<td><a href="{{ '/pdf/'.$fact['jaar'].'-'.$fact['factuurvolgnummer'].'/show' }}" class="btn btn-primary">bekijk</a></td>
				  </tr>
				  @endforeach
				</tbody>
		      </table>
			</ul>
		</div>
	</div>
</div>