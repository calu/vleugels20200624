@extends('layouts.vleugelslayout')

@section('content')
  <div class="container" id="mutformulier">
    <mutformulier @completed="vermelden" :data="{{ $mutualiteiten }}"></mutformulier>
    <!-- formulier @completed="vermelden"></formulier -->
  </div>
@endsection
