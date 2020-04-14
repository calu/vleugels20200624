<div class="tab-pane fade show" id="pills-klant" role="tabpanel" aria-labelledby="pills-klant-tab">
	@php
	// dd($info);
   $info['service']['typedescription'] = \App\Enums\ServiceType::getDescription($info['service']['serviceable_type']);
	
	@endphp
	<client @completed="vermelden" :data="{{ json_encode($info) }}"></client>	
</div>