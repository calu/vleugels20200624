@extends('layouts.vleugelslayout')

@section('content')

<div class="container">
	<div class="row justify-content-center mt-4">
		<div class="col-md-8">
			<div class="card">
				<h2 class="cord-header text-center bg-primary">Wachtwoord vernieuwen</h2>
				
				<div class="card-body">
									
					<form method="POST" action="{{ url('wachtwoord/vernieuwen') }}">
                        @csrf
                                                   
                        <input type="hidden" name="token" value="{{ $data['token'] }}">
                        <input type="hidden" name="user_id" value="{{ $data['user_id'] }}">


                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">
                               Het e-mail adres
                            </label>

                            <div class="col-md-6">
                                <input id="email" type="email" 
								       class="form-control @error('email') is-invalid @enderror" 
									   name="email" value="{{ $data['email'] }}" readonly="readonly" 
									   disable="disabled">
                            </div>                                                      
                        </div>
                        
                        <input type="hidden" name="user_id" value="{{ $data['user_id'] }}" ></input>
                        
                        <div class="form-group row">
                            <label for="wachtwoord" class="col-md-4 col-form-label text-md-right">
                                geef een nieuw wachtwoord
                            </label>

                            <div class="col-md-6">
                                <input id="wachtwoord" type="text" class="form-control" name="wachtwoord" autofocus>

                                @error('wachtwoord')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>                            
                        </div>                        

                        <div class="form-group row">
                            <label for="wachtwoordbis" class="col-md-4 col-form-label text-md-right">
                                herhaal wachtwoord
                            </label>

                            <div class="col-md-6">
                                <input id="wachtwoordbis" type="text" class="form-control" name="wachtwoordbis" autofocus>

                                @error('wachtwoordbis')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>                            
                        </div>     
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                   Verzend
                                </button>
                                
                            </div>
                        </div>                        
                    </form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
