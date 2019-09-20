<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts2.basislayout')  
    @include('layouts.splash')   
</head>
<body>
    <div id="app">
        
        @include('partials.navbar')
        
        <main>
            @yield('content')
        </main>
    </div>
    
    @include('layouts2.footer')
</body>
</html>