<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('img/logo2.png') }}">
    <link href="{{asset('css/app.css') }}" rel="stylesheet">
    <link href="{{asset('css/loginRegister.css') }}" rel="stylesheet">
    <script src="{{asset('js/app.js') }}" defer></script>
    <title>@yield('title')</title>
</head>
<body>
<div class="position-absolute">
    <img height="60" width="60" src="{{ asset('img/logo2.png') }}">
    <span class="text-black-50" style="top: 10px;font-size: 1.8em; font-weight: lighter">Guacatube</span>
</div>

<div class="vh-100 d-flex justify-content-center align-items-center">
    @yield('content')
</div>
</body>
</html>
