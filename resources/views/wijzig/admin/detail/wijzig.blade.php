<div class="tab-pane fade show active" id="pills-wijziging" role="tabpanel" aria-labelledby="pills-wijziging-tab">
	@php
    $info['wijzig']['typedescription'] = \App\Enums\ServiceType::getValue($info['wijzig']->serviceable_type);
//	dd($info['wijzig']);
	@endphp
	<adminwijzig @completed="vermelden" :data="{{ json_encode($info['wijzig']) }}"></adminwijzig>	
</div>
