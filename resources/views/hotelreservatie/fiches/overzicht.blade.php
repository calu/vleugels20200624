<h2 class="d-flex justify-content-center">overzicht van de overnachting aanvragen</h2> 
@if ($hotels->count() == 0)
	<h2 class="d-flex justify-content-center text-success">Geen aanvragen</h2>
@else
<table class="table">
	<thead class="thead-dark">
		<th>begindatum</th>
		<th>einddatum</th>
		<th>status</th>
		<th></th>
	</thead>
	<tbody>
	@foreach ($hotels as $hotel)
	<tr>
		<td>{{ $hotel->begindatum }}</td>
		<td>{{ $hotel->einddatum }}</td>
		<td>{{ $hotel->status }}</td>
		<td><a href="hotels/{{ $hotel->id }}" class="btn btn-primary">detail</a></td>
	<tr>
	@endforeach
	</tbody>
</table>
@endif
<div class="pt-4">&nbsp;</div>