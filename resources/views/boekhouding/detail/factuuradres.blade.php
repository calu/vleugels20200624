<div class="tab-pane fade show" id="pills-factuuradres" role="tabpanel" aria-labelledby="pills-factuuradres-tab">
	@php
	//dd($info);
   $info['service']['typedescription'] = \App\Enums\ServiceType::getDescription($info['service']['serviceable_type']);
	
	@endphp
	<factuuradres @completed="vermelden" :data="{{ json_encode($info) }}"></factuuradres>	
</div>