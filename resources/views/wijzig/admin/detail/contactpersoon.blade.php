<div class="tab-pane fade show " id="pills-contactpersoon" role="tabpanel" aria-labelledby="pills-contactpersoon-tab">
	@php
	$soort = $info['wijzig']->serviceable_type;
//	dd($info);
	$info['contactpersoon']->urlterug = '/wijzig/admin/overzicht';

	@endphp
    <contactpersoon @completed="vermelden" :data="{{ json_encode($info['contactpersoon']) }}"></contactpersoon>
</div>
