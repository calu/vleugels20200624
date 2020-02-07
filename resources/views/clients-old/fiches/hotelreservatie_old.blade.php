<section id="hotelreservatie-section">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">een kamer reserveren</h4>

        <div class="d-flex ml-8 container ml-3">
          
          <form class="form-inline" method="post" action="/hotels/reserveer">
            @csrf
            <input type="hidden" id="client_id" name="client_id" value="{{ $client->id}}" />
            <label for="begindatum" class="col-sm-3 col-form-label">begindatum</label>
            <input type="date" class="form-control mb-2 mr-sm-2" id="begindatum" name="begindatum"/>

            <label for="einddatum" class="col-sm-3 col-form-label">einddatum</label>
            <input type="date" class="form-control mb-2 mr-sm-2" id="einddatum" name="einddatum" />

            <label for="kamernummer" class="col-sm-3 col-form-label">kamernummer</label>
            <input type="text" class="form-control mb-2 mr-sm-2" id="kamernummer" name="kamernummer" />
            
            <button type="submit" class="btn btn-primary mb-2">Bevestig</button>
          </form>
          
 @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif         

        </div>
     
      </div>
    </div>
  </div>
</section>