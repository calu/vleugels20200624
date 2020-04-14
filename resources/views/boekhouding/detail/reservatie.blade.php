<div class="tab-pane fade show" id="pills-reservatie" role="tabpanel" aria-labelledby="pills-reservatie-tab">
	@php
    $info['service']['typedescription'] = \App\Enums\ServiceType::getDescription($info['service']['serviceable_type']);
//	dd($info['service']);
	@endphp
	<reservatie @completed="vermelden" :data="{{ json_encode($info['service']) }}"></reservatie>	
</div>
