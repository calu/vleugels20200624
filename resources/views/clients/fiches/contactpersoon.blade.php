<section id="contactpersoon-section">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">contactpersoon</h4>

       <div class="d-flex ml-6 container">
          <ul class="list-group col-sm-8">
            
            <li class="list-group-item d-flex justify-content-between lh-condensed">
              <div>
                <h6 class="my-0">relatie met klant</h6>
                <p class="text-muted"> {{ $contactpersoon->relatie }} </p>
              </div>
            </li>

            
            <li class="list-group-item d-flex justify-content-between lh-condensed">
              <div>
                <h6 class="my-0">adres</h6>
                <p class="text-muted">
                   {{ $contactpersoon->straat.",".$contactpersoon->huisnummer }}
                   <?php if (strlen($contactpersoon->bus) > 0){ echo ('<b>bus : </b>'.$contactpersoon->bus); } ?>
                </p>
                <p>{{ $contactpersoon->postcode." ".$contactpersoon->gemeente }}</p>    
              </div>
            </li>
        
            <li class="list-group-item d-flex justify-content-between lh-condensed">
              <div> <!-- telefoon   gsm -->
                <h6 class="my-0">telefoon en gsm</h6>
                <p class="text-muted">
                  <p> <b>telefoon : </b> {{ $contactpersoon->telefoon }} </p>
                  <p> <b>gsm : </b> {{ $contactpersoon->gsm }} </p>
                </p>
              </div>
            </li>
 
             <li class="list-group-item d-flex justify-content-between lh-condensed">
              <div> <!-- e-mail -->
                <h6 class="my-0">e-mail</h6>
                <p class="text-muted"> {{ $contactpersoon->email}}</p>
              </div>
            </li>    
            
            <li class="list-group-item d-flex justify-content-between lh-condensed">
              <div> <!-- e-mail -->
                <h6 class="my-0">rubriek</h6>
                <p class="text-muted"> {{ $contactpersoon->rubriek }} </p>
                
                <h6 class="my-0">vraag</h>
                <p>
                  <textarea rows="4" cols="60">{{ $contactpersoon->vraag }}</textarea>
                </p>
              </div>
            </li>       
                              
          </ul>  
        </div>
      </div>
    </div>
  </div>
</section>
