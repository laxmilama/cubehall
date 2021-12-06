<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="mobile-web-app-capable" content="yes">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#d82448"/>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <script type='text/javascript' charset='utf-8'>
        // Hides mobile browser's address bar when page is done loading.
        window.addEventListener('load', function(e) {
            setTimeout(function() { window.scrollTo(0, 1); }, 1);
        }, false);
    </script>

    <link rel="stylesheet" href="{{asset('./css/app.css')}}">
    <link rel="manifest" href="/manifest.json">
    <link rel="icon" href="/favicon.png" type="image/x-icon">
    <title>@yield('title', 'Login')  - {{env('APP_NAME')}}</title>
    <script>
        const currentTheme = localStorage.getItem("theme");

        if (currentTheme) {
        document.documentElement.setAttribute("data-theme", currentTheme);
        }
    </script>
</head>
    <body>
        <div>
            @yield('content')
        </div>

        <script src="{{asset('./js/scroller.js')}}"></script>
        <script src="{{asset('js/app.js')}}"></script>
        <script src="{{asset('js/main.js')}}"></script>
    </body>
</html>