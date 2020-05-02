@extends('layouts.vleugelslayout')
@php
//  dd($info);    
$info['factuur']->urlterug = '/wijzig/admin/overzicht';
$info['factuur']->factuur_id = $info['factuur']->id;
$info['factuur']->inlineRadioOptions = 'ja';
@endphp
@section('content')
<div class="super-container">
  <h2 class="d-flex justify-content-center">Afdrukken van de factuur</h2>	
  @include('partials.flash')    
  <factuurdruk @completed="vermelden" :data="{{ json_encode($info['factuur']) }}"></factuurdruk>		
</div>
@endsection

