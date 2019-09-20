
<section id="allservices-section">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">alle diensten</h4>

        <div class="d-flex ml-7 container">

          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>soort</th>
                  <th>begindatum</th>
                  <th>prijs</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                
                @foreach($services as $service)
                  <?php
                    // dd($service);
                    $serviceType = $service->serviceable_type;
                    switch ($serviceType){
                      case 'App\Hotel' :
                        $type = "hotel";
                        $hotel = DB::table('hotels')->where('id', $service->serviceable_id)->get()->first(); 
//                                dd($hotel);
                        $datum = $hotel->begindatum;
                        $prijs = $hotel->bedrag;
                        $status = $hotel->status;
                        switch ($status){
                          case 'aangevraagd' :
                            $badgecode = 'badge-success';
                            break;
                          case 'goedgekeurd' :
                            $badgecode = 'badge-primary';
                            break;
                           case 'actief' :
                            $badgecode = 'badge-danger';
                            break;   
                           case 'voorbij' :
                            $badgecode = 'badge-secondary';
                            break;   
                           case 'wijzigingsaanvraag' :
                            $badgecode = 'badge-dark';
                            break;                                                                                                       
                        }                                
                        break;
                      case 'App\Dagverblijf' :
                        $type = "dagverblijf";
                        $datum = $service->datum;
                        $prijs = $service->bedrag;
                        break;
                      case 'App\Therapie';
                        $type = 'therapie';
                        $datum = $service->datum;
                        $prijs = $service->bedrag;
                        break;
                    }         
                  ?>
                  <tr>
                    <td>{{ $type }}</td>
                    <td>{{ $datum }}</td>
                    <td>{{ $prijs }}</td>
                    <td><label class="badge {{ $badgecode }}">{{ $status }}</label></td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>