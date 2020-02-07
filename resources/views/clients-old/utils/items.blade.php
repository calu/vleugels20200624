<?php
  // dd($service);
  $serviceType = $service->serviceable_type;
  switch ($serviceType){
    case 'App\Hotel' :
      $type = "hotel";
      $hotel = DB::table('hotels')->where('id', $service->serviceable_id)->get()->first();  
      // dd($hotel);
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
  <td scope="row">{{ $type }}</td>
  <td scope="row">{{ $datum }}</td>
  <td scope="row">
    <a href="#" class="btn btn-sm btn-rounded btn-success">{{ $prijs }}</a>    
  </td>
  <td scope="row">
    <a href="#" class="btn btn-sm btn-rounded {{ $badgecode }}">{{ $status }}</a>
  <td scope="row">
    <button onclick="location.href='http://www.example.com'"  type="button" class="btn btn-success btn-rounded btn-icon-text">
      Edit
      <i class="mdi mdi-file-check btn-icon-append"></i>                          
     </button>
  </td>
</tr>                 