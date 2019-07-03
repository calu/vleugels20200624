@extends('layouts.vleugelslayout')

@section('content')
  <div class="container" id="codeformulier">
    <code-formulier @completed="vermelden" :data="{{ $codes }}"></code-formulier>
    <!-- formulier @completed="vermelden"></formulier -->
  </div>
@endsection
