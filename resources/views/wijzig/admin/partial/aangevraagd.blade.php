<div class="tab-pane fade show active" id="pills-aangevraagd" role="tabpanel" aria-labelledby="pills-aangevraagd-tab">
  @if (empty($aangevraagd))
    <p class="text-bold text-center">Er zijn geen aangevraagde wijzigingen of annulaties</p>
  @else
  @php
  // dd($aangevraagd);
  @endphp
  <table class="table table-striped">
    <thead>
      <tr>
        <td>rubriek</td>
        <td>service</td>
        <td>omschrijving</td>
        <td></td>
      </tr>
    </thead>
    <tbody>
    @foreach($aangevraagd as $item)
      @php
      $id = $item->serviceable_id;
      $type = $item->serviceable_type;
      $client = \App\Helper::getClientFromServiceable($id,$type);
      $omschrijving = "voor ".$client->voornaam." ".$client->familienaam;
      @endphp
      <tr>
        <td>{{ $item->rubriek }}</td>
        <td>{{ $item->serviceable_type }}</td>
        <td>{{ $omschrijving }}</td>
        <td>
          <a class="btn btn-primary" href="/wijzig/admin/{{ $item->id }}/detail">detail</a>
        </td>      
      </tr>
    @endforeach
    </tbody>
  </table>
  @endif	
</div>



