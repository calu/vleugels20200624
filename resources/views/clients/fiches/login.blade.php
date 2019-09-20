<section id="login-section">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">aanmeld gegevens</h4>

        <div class="d-flex ml-3 container">
          
         <div class="container ">
           <div class="row">
              <div class="col"><b>aanmeldnaam :</b> {{ $user->email }}</div>
              <div class="w-100"></div>
              <div class="col">
                <a href="#" class="btn btn-rounded btn-primary">wijzig wachtwoord</a>
              </div>
            </div>
          </div>         
        </div>
      </div>
    </div>
  </div>
</section>