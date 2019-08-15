<table class="table table-hover table-bordered table-primary text-dark">
	<tbody>
	@foreach($kamers as $kamer)
		@include('kamers.kamerdetail')
	@endforeach		
	</tbody>
</table>

