<div class="tab-pane fade show" id="pills-contactpersoon" role="tabpanel" aria-labelledby="pills-contactpersoon-tab">
	@php
	// dd($info);
   $info['service']['typedescription'] = \App\Enums\ServiceType::getDescription($info['service']['serviceable_type']);
	
	@endphp
	<cp @completed="vermelden" :data="{{ json_encode($info) }}"></cp>	
</div>