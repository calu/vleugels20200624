<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.basislayout')
    @include('hotels.layouts.radissonbasis')
    <style>
    html, body {
          font-size : 1.1rem;
          font-weight : 400;
          height : 100%;
    }
    
    </style>
        
</head>
<body>
    <div id="app">
        
        @include('partials.navbar')
        
        <main class="py-4">
            @yield('content')
        </main>
		
		@include('hotels.layouts.footer')
    </div>
</body>
</html>