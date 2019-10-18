@extends('layouts.vleugelslayout')

@section('content')

<?php // dd($results); ?>
	<?php
		class MyEvent {
			public function __construct($id, $startDate, $endDate, $title, $url = NULL, $style = NULL)
			{
				$this->id = $id;
				$this->startDate = $startDate;
				$this->endDate = $endDate;
				$this->title =$title;
				$this->url = $url;
				$this->style = $style;
			}
		}
		
		
		$events = [];
		foreach($results as $result)
		{
			$obj = new MyEvent($result['id'], $result['begindatum'], $result['einddatum'], $result['kamernummer'].'/'.$result['status'].'/'.$result['bedrag'],NULL, 'orange' );
			$events[] = $obj;
		}
		$jsonevents = json_encode($events);
		// dd($jsonevents);
	?>
	<calendar-component v-bind:events="{{ $jsonevents }}"></calendar-component>
@endsection