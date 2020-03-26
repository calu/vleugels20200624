@extends('layouts.vleugelslayout')

@section('content')
<div class="super-container">
  <div id="knoppen" class="d-flex justify-content-center">
    <a class="btn  btn-primary mr-2" href="#tefacturerendiensten">
      Te factureren diensten
    </a>

    <a class="btn  btn-primary mr-2" href="#gefactureerdediensten">
      Gefactureerde diensten
    </a>	
    
    <a class="btn  btn-primary" href="#facturenperklant">
      Facturen per klant
    </a>    
  </div> 
      
      
  @include('boekhouding.fiches.tefactureren')    

      
      <div class="container" id="gefactureerdediensten">
        gefactureerde diensten
      </div>

      <div class="container" id="facturenperklant">
        facturen per klant
      </div>

  </div>


@endsection