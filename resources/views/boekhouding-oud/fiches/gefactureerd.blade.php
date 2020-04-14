@php
/* we halen alle info op voor gefactureerde diensten */
$facturen = DB::table('factuurs')->orderBy('datum', 'desc')->get();
// dd($facturen);
@endphp
<div class="container" id="gefactureerdediensten">
   <div class="card" style="width: 100%;">
     <div class="card-body">
       <h2 class="card-title">gefactureerde diensten</h2>
       <h6 class="card-subtitle mb-2 text-muted">Overzicht van alle gefactureerde diensten</h6>

       <table class="table table-striped">
        <thead>
          <tr>
            <td>dienst</td>
            <td>factuurdatum</td>
            <td>bedrag</td>
            <td>betaald</td>
            <td></td>
          </tr>
        </thead>
        <tbody>
        @if ($facturen->isEmpty())
            <td colspan="4" class="text-center">nog geen facturen afgewerkt</td>
        @else
        @foreach($facturen as $factuur)
          @php
          $dienst = App\Enums\ServiceType::getDescription($factuur->serviceable_type);
          
          // dd($factuur);
          @endphp
          <tr>
            <td>{{ $dienst }}</td>
            <td>{{ $factuur->datum }}</td>
            <td>{{ $factuur->prijs }}</td>
            <td>
              @if ($factuur->betaald)
                <i class="far fa-thumbs-up"></i>
              @else
                <i class="far fa-thumbs-down"></i>
              @endif
            </td>
            <td><a href="/factuur/{{ $factuur->id }}" style="btn btn-primary">detail</td>
          </tr>
        @endforeach
        @endif
		    </tbody>
	   </table>
	  </div>
	 </div>
</div>