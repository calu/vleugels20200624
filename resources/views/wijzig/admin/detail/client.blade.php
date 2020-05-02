<div class="tab-pane fade show " id="pills-client" role="tabpanel" aria-labelledby="pills-client-tab">
	@php
	$soort = $info['wijzig']->serviceable_type;
//	dd($info);
    $service['serviceable_id'] = $info['wijzig']->serviceable_id;
	$service['typedescription'] = $soort;
	$info['client']->typedescription = $soort;
	$info['service'] = $service;
	
	$mutualiteiten = \App\Mutualiteit::all(); 
    $statuten = \App\Enums\StatuutType::getInstances();
    $info['mutualiteiten'] = $mutualiteiten;
    $info['statuten'] = $statuten;	
	$info['urlterug'] = '/wijzig/admin/overzicht';
	@endphp
    <client @completed="vermelden" :data="{{ json_encode($info) }}"></client>
</div>
