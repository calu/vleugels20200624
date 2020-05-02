<div class="tab-pane fade show " id="pills-service" role="tabpanel" aria-labelledby="pills-service-tab">
	@php
	$soort = $info['wijzig']->serviceable_type;
//	dd($info);
	@endphp
	<!-- onderzoek welke service dit is -->
	@switch ($soort)
		@case ('hotel')
			<hotel @completed="vermelden" :data="{{ json_encode($info['hotel']) }}"></hotel>
			@break
		@case ('dagverblijf')
			<h2>TODO dagverblijf</h2>
			@break
		@case ('therapie')
			<h2>TODO therapie</h2>
			@break
	@endswitch 
</div>
