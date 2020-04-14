@php
/* in dit onderdeel verzamelen we alle gegevens over de diensten die nog 
   moeten gefactureerd worden. Dit zijn alle diensten die in het veld status
   als "aangevraagd" staan.
   
   We verzamelen alle gegevens voor hotels, dagverblijf en therapie
 */
 
 $hotels = DB::table('hotels')->where('status', 'aangevraagd')->get();
 /* TODO
 $dagverblijfs
 $therapies
 ** einde TODO */
 // dd($hotels);
@endphp

<div class="container" id="tefacturerendiensten">
   <div class="card" style="width: 100%;">
     <div class="card-body">
       <h2 class="card-title">te factureren diensten</h2>
       <h6 class="card-subtitle mb-2 text-muted">Overzicht van alle te factureren diensten</h6>

       <table class="table table-striped">
        <thead>
          <tr>
            <td>type</td>
            <td>omschrijving</td>
            <td></td>
          </tr>
        </thead>
        <tbody>
          @foreach ($hotels as $hotel)
            <tr> 
              <td>hotel</td>
              <td>verblijf van {{ $hotel->begindatum}} tot {{ $hotel->einddatum }}</td>
              <td>
                <a class="btn btn-primary" href="/boekhouding/{{ $hotel->id }}/hotel/detail">toon detail</a>
              </td>
            </tr>
          @endforeach
      </table>    
      
     </div>
   </div>
</div>