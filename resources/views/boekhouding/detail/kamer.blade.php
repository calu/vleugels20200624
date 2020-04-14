<div class="tab-pane fade show" id="pills-kamer" role="tabpanel" aria-labelledby="pills-kamer-tab">
	@php
	// dd($info);
   $info['service']['typedescription'] = \App\Enums\ServiceType::getDescription($info['service']['serviceable_type']);
	
	@endphp
	<h2>hier komen de kamerdetails, maar we wachten met implementatie toe we hierover meer uitleg hebben gekregen</h2>
</div>