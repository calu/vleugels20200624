
@php
//dd($info);
$dinfo = json_decode($info);
@endphp
<h4 class="text-info d-flex justify-content-center">Gegevens over de klant:</h4>
<div class="form-row">
	<div class="form-group col-md-12">
		<label for="wijzig-wijziging">de gevraagde wijziging</label>
		<textarea class="form-control" rows="5" disabled="disabled">
			{{ $dinfo->wijzig_wijziging }}
		</textarea>
	</div>
</div>

<div class="form-row">
  <div class="form-group col-md-6">
	  <label for="client_vollenaam">naam klant</label>
	  <input type="text" class="form-control" id="client_vollenaam" 
	         disabled="disabled" value="{{ $dinfo->client_vollenaam }}" />
  </div>
</div>

<h4 class="text-info d-flex justify-content-center">Gegevens over de contactpersoon:</h4>
<div class="form-row">
  <div class="form-group col-md-6">
    <label for="contactpersoon_vollenaam">contactpersoon</label>
	<input type="text" class="form-control" id="contactpersoon_vollenaam"
	       disabled="disabled" value="{{ $dinfo->contactpersoon_vollenaam }}" />
  </div>
</div>

<div class="form-row">
  <div class="form-group col-md-6">
    <label for="contactpersoon_adres1">straat en nummer</label>
	<input type="text" class="form-control" id="contactpersoon_adres1"
	       disabled="disabled" value="{{ $dinfo->contactpersoon_adres1 }}" />
  </div>
  <div class="form-group col-md-6">
    <label for="contactpersoon_adres2">postcode en gemeente</label>
	<input type="text" class="form-control" id="contactpersoon_adres2"
	       disabled="disabled" value="{{ $dinfo->contactpersoon_adres2 }}" />
  </div>  
</div>

<div class="form-row">
  <div class="form-group col-md-6">
    <label for="contactpersoon_telefoon">telefoon</label>
	<input type="text" class="form-control" id="contactpersoon_telefoon"
	       disabled="disabled" value="{{ $dinfo->contactpersoon_telefoon }}" />
  </div>
  <div class="form-group col-md-6">
    <label for="contactpersoon_gsm">gsm</label>
	<input type="text" class="form-control" id="contactpersoon_gsm"
	       disabled="disabled" value="{{ $dinfo->contactpersoon_gsm }}" />
  </div>  
</div>

<div class="form-row">
  <div class="form-group col-md-6">
    <label for="contactpersoon_email">telefoon</label>
	<input type="text" class="form-control" id="contactpersoon_email"
	       disabled="disabled" value="{{ $dinfo->contactpersoon_email }}" />
  </div>
</div>
