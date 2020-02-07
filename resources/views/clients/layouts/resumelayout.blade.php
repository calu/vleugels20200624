<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('clients.layouts.basislayout')    
</head>
<body id="page-top">
    <div id="app" class="container-fluid" style="width:100%">
        @include('partials.navbar') 
        
        <main class="container-fluid" style="width:100%">
            @yield('content')
        </main>        
    </div>
    
    @include('partials.footer')
        <!-- Custom scripts for this template -->
    <script src="{{ asset('resume/js/resume.min.js') }}"></script>     
</body>
</html>