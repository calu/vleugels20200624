@extends('layouts.vleugelslayout')

@section('content')
  <div class="container" id="codeformulier">
     <h1 class="d-flex justify-content-center">Aanpassen van de kamerprijs</h1>
    
    <code-formulier @completed="vermelden" :data="{{ $codes }}"></code-formulier>
    <!-- formulier @completed="vermelden"></formulier -->
  </div>
@endsection
