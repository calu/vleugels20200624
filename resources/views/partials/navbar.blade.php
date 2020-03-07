<header class="navbar navbar-expand navbar-dark flex-column flex-md-row bd-navbar">
	<a class="navbar-brand mr-0 mr-md-2" href="/" aria-label="De Vleugels">
           <img src="{{ asset('/img/logovleugels.png') }}" width="88" height="48">		
	</a>
            <!-- rechterzijde van de navbar -->
	
	<ul class="navbar-nav ml-md-auto">
		@guest
	        <li class="nav-item">
	            <a class="nav-link text-danger" href="{{ route('login') }}">{{ __('Login') }}</a>
	        </li>
	        <li class="nav-item">
	            <a class="nav-link text-danger" href="{{ url('contactpersonen/create') }}">Stel je vraag</a>
	        </li>			
		@else
                   <!-- aangemeld als admin of klant -->
                   @if ( Auth::user()->admin == 1)
                        <!-- admin -->
                        <li class="nav-item">
                            <a class="nav-link  text-danger" href="/home">top</a>
                        </li>
                        
                        @if ( request()->session()->has('client_id'))
                          <!-- admin maar voor klant -->
                          <?php
                              $id = Session::get('client_id');
                             
                              try{
                                  $client = \App\Client::findOrFail($id);
                              } catch ( Exception $e){
                                  dd("meld fout aan beheerder (1)");
                              }
                          ?>
                          
                          @isset( $client )
                            <li class="nav-item text-white">
                                <p class="nav-link  text-danger">voor {{ $client->voornaam." ".$client->familienaam }}</p>
                            </li>
                            &nbsp;
                          @endisset
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link  text-danger" href="/home">top</a>
                        </li>
                   @endif
                   
                   <li class="nav-item dropdown">
                       <a id="navbarDropdown" class="nav-link dropdown-toggle text-danger" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                           {{ Auth::user()->name }} <span class="caret"></span>
                       </a>                  
                   </li>

                   <li class="nav-item mt-2">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="bg-dark text-white border-dark">logout</button>
                        </form>                                    
                   </li>
			
		@endguest
	</ul>
</header>