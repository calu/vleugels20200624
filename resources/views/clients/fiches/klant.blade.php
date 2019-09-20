<section id="klant-section">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">klantgegevens</h4>
          
        <div class="d-flex ml-6 container">
          <ul class="list-group col-sm-8">
            <!-- straat, nr, bus postcode gemeente --> 
            <li class="list-group-item d-flex justify-content-between lh-condensed">
              <div>
                <h6 class="my-0">adres</h6>
                <p class="text-muted">
                   {{ $client->straat.",".$client->huisnummer }}
                   <?php if (strlen($client->bus) > 0){ echo (' bus : '.$client->bus); }; ?>
                </p>
                <p>{{ $client->postcode." ".$client->gemeente }}</p>    
              </div>
            </li>
            <li class="list-group-item d-flex justify-content-between lh-condensed">
              <div> <!-- telefoon   gsm -->
                <h6 class="my-0">telefoon en gsm</h6>
                <p class="text-muted">
                  <p> <b>telefoon : </b> {{ $client->telefoon }}</p>
                  <p> <b>gsm : </b> {{ $client->gsm }} </p>
                </p>
              </div>
            </li>
            
            <!-- geboortedatum rijksregisternummer -->
            <!-- statuut en mutualiteit -->
            <?php   
              $mut = \App\Mutualiteit::findOrFail($client->mutualiteit_id);
              $mutnaam = $mut->naam;
            ?>  
            
             <li class="list-group-item d-flex justify-content-between lh-condensed">
              <div>
                <h6 class="my-0">overige gegevens</h6>
                <p class="text-muted">
                  <p> <b>geboortedatum : </b> {{ $client->geboortedatum }}</p>
                  <p> <b>rijksregisternummer : </b> {{ $client->rrn }} </p>
                  <p> <b>statuut : </b> {{ \App\Enums\StatuutType::getDescription($client->statuut) }} </p>
                  <p> <b>mutualiteit : </b> {{ $mutnaam }} </p>
                </p>
              </div>
            </li>           
          </ul>  
        </div>
      </div>
    </div>
  </div>
</section>