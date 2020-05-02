<div class="tab-pane fade show " id="pills-factuur" role="tabpanel" aria-labelledby="pills-factuur-tab">
	@php
	$soort = $info['wijzig']->serviceable_type;
//	dd($info);
//	$info['factuur']->urlterug = '/wijzig/admin/overzicht';
	@endphp
	
   @foreach( $info['factuur'] as $item)
     @php
//   	 dd($item);
		$item->urlterug = 'factuur/'.$item->id.'/drukken';   //'/wijzig/admin/overzicht';
		$item->mogelijknr = $info['factuur']->mogelijknr;
		$item->mogelijkjaar = $info['factuur']->mogelijkjaar;
	 @endphp
     <factuur @completed="vermelden" :data="{{ json_encode($item) }}"></factuur>	 
   @endforeach
	
  
</div>
