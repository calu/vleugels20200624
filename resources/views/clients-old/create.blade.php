@extends('layouts.vleugelslayout')

@section('content')
  <div class="container" id="codeformulier">
    <intake-formulier @completed="vermelden" :data="{{ $data }}"></intake-formulier>
    <!-- formulier @completed="vermelden"></formulier -->
  </div>
@endsection
