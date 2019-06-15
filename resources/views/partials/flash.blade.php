@if ($flash = session('bericht'))
   <div class='alert alert-success text-center' role='alert'>
     {{ $flash }}
   </div>
@endif
