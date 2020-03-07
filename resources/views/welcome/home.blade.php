<div class="home vlinder" style="width:100%">
  <div class="home_container" style="width:100%">
    @include('partials.flash')
	  <div class="container-fluid">
		  <div class="row">
			  <div class="col">
				  <div class="home_content text-center">
					  <div class="home_title">
						  <img src="{{ asset('img/logovleugels.png')}}" >
					  </div>
					  
					  <div class="home_text">
						  <a class="btn btn-primary" href="#hotel" role="button">Hotel</a>
						  <a class="btn btn-primary" href="#dagverblijf" role="button">Dagverblijf</a>
						  <a class="btn btn-primary" href="#therapie" role="button">Therapie</a>	
                           <!-- als aangemeld als klant of als admin (en daar als klant) -->
                		   @if ( Auth::check() && Auth::user()->name)
                             <a class="btn btn-primary" href="clients/{{ Auth::user()->id }}"
                                 role="button">detailinfo van klant</a>
                           @endif	
					  </div>
				  </div>
			  </div>
		  </div>
	  </div>
  </div>
</div>
