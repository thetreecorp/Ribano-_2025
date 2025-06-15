<html lang="{{ app()->getLocale() }}" dir="{{ session('direction') }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-title" content="{{ config('settings.app.name') }}">
    <title>Ribano</title>

    <link rel="canonical" href="{{ request()->fullUrl() }}" />
    <base target="_top" />


    @stack('before_styles_stack')
    @yield('before_styles')
    
    @stack('after_styles_stack')
    @yield('after_styles')

    

</head>

<body class="skin">
   
    <div id="wrapper">

       

      

        @yield('content')

      


    </div>





    @stack('before_scripts_stack')
    @yield('before_scripts')

    
    @stack('scripts')
    

</body>

</html>
