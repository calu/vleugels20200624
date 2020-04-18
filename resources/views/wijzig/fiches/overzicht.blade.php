<div class="card" style="width: 100%">
  <div class="card-body">
    <h5 class="card-title text-primary text-center">Overzicht van de aangevraagde dienst</h5>
    <h6 class="card-subtitle mb-2 text-muted text-center">Dit is enkel een overzicht</h6>
    @switch ( $info['serviceable_type'])
      @case('hotel')
        <hotelfiche @completed="vermelden" :data="{{ json_encode($info['service']) }}"></hotelfiche>
        @break
      @case('dagverblijf')
        <!-- TODO -->
        @break
      @case('therapie')
        <!-- TODO -->
        @break
    @endswitch
   </div>
</div>