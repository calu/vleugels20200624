<section id="facturatie-section">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">facturatie adres</h4>

       <div class="d-flex ml-6 container">
          <ul class="list-group col-sm-8">
            
            <li class="list-group-item d-flex justify-content-between lh-condensed">
              <div>
                <h6 class="my-0">naam</h6>
                <p class="text-muted">
                   {{ $client->factuur_naam }}
                 </p>
              </div>
            </li>

            
            <li class="list-group-item d-flex justify-content-between lh-condensed">
              <div>
                <h6 class="my-0">adres</h6>
                <p class="text-muted">
                   {{ $client->factuur_straat.",".$client->factuur_huisnummer }}
                   <?php if (strlen($client->factuur_bus) > 0){ echo (' bus : '.$client->factuur_bus); }; ?>
                </p>
                <p>{{ $client->factuur_postcode." ".$client->factuur_gemeente }}</p>    
              </div>
            </li>
        
            <li class="list-group-item d-flex justify-content-between lh-condensed">
              <div>
                <h6 class="my-0">e-mail</h6>
                <p class="text-muted">
                  <?php 
                    if (strlen($client->factuur_email) > 0)
                       echo($client->factuur_email);
                    else
                       echo('geen e-mail adres gekend');
                  ?> 
                </p>
              </div>
            </li>
                
          </ul>  
        </div>
      </div>
    </div>
  </div>
</section>
