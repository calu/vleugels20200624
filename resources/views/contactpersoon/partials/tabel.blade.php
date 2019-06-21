@if ($soort == 'openstaand')
  <?php $titel = "Overzicht van aanvragen"; ?>
@else
  <?php $titel = "Overzicht van afgewerkte aanvragen"; ?>
@endif


<div class="container">
	<h2 class="d-flex justify-content-center">{{ $titel }}</h2>
	
	@if ( count($data) == 0)
		<h3 class="d-flex justify-content-center">Er zijn geen items</h3>
	@else
	
		<table class="table table-hover table-bordered table-sm table-primary text-dark">
			<thead>
				<th>naam</th>
				<th>rubriek</th>
				<th>vraag</th>
				<th></th>
			</thead>
			<tbody>
				@foreach($data as $item)
				<tr>
					<td>{{ $item->voornaam." ".$item->familienaam }}</td>
					<td>{{ $item->rubriek }}</td>
					<td>{{ $item->vraag }}</td>
					<td>
						@if ($soort == 'openstaand')
						<a class="btn btn-primary" href="/contactpersonen/{{ $item->id }}/edit" title="Wijzig de invoer" role="button">
							edit
						</a>
						
						<a class="btn btn-primary" href="/clients/{{ $item->id }}/createWithId" title="Wijzig de invoer" role="button">
							intake
						</a>							
						@endif
						
						<button type="button"  class="btn btn-primary" data-toggle="modal" data-target="#intakemodal">
							wis
						</button>
						
					</td>
				</tr>
				
				<?php $url = '/contactpersoon/'.$item->id.'/destroy'; ?>
	<!-- zie vleugels8 include('partials.modal',['href' => 'intakemodal', 'url' => $url ])	-->	
				
				@endforeach
				{{ $data->links() }}
			</tbody>
		</table>
		
	@endif
</div>