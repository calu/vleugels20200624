@extends('layouts.vleugelslayout')
@php
// dd($client);    
@endphp
@section('content')
<div class="container">
  <h2 class="text-center">reservatie</h2>
  <h4 class="text-center text-primary">reserveer</h4>
  
 <hotelreservatie @completed="vermelden" 
      :data="{{ $info }}"></hotelreservatie>    
  
  <!-- plaats hier een overzicht van reeds gedane reservaties -->
  <h4 class="text-center text-primary">overzicht van reeds gevraagde reservaties</h4>
</div>
@endsection