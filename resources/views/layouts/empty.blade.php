<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="{{asset('./css/app.css')}}">
    <title>Page not found - 404 Error! - {{env('APP_NAME')}}</title>
    <link rel="icon" href="/favicon.png" type="image/x-icon">
    <script>
        const currentTheme = localStorage.getItem("theme");

        if (currentTheme) {
        document.documentElement.setAttribute("data-theme", currentTheme);
        }
    </script>
</head>
    <body>
        <div class="">
            @yield('content')
        </div>
    </body>
</html>