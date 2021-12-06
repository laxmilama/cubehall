 <!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="mobile-web-app-capable" content="yes">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="theme-color" content="#d82448"/>
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
	<title>@yield('title', 'Admin Dashboard') - CubeHall</title>
  <link rel="stylesheet" type="text/css" href="{{asset('css/admin.css')}}">
  <link rel="icon" href="/favicon.png" type="image/x-icon">
  <script>
    const currentTheme = localStorage.getItem("theme");

    if (currentTheme) {
    document.documentElement.setAttribute("data-theme", currentTheme);
    }
</script>
	</head>
<body>
  @include('layouts.adminLayout.header')

@include('layouts.adminLayout.sidebar')

@yield('content')

@include('layouts.adminLayout.footer')

 

      
</div>
  <script src="{{asset('js/adminjs/script.js')}}"></script>
  <script src="{{asset('js/moment.min.js')}}"></script>
	<script src="{{asset('js/Chart.min.js')}}"></script> 
  </body>
</html>