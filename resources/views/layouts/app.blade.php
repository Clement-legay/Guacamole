<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('img/logo2.png') }}">
    <link href="{{asset('css/app.css') }}" rel="stylesheet">
    <script src="{{asset('js/app.js') }}" defer></script>
    <title>@yield('title')</title>
</head>
<body>
@extends('layouts.nav')

    <div class="row p-0 m-0">
        <div class="col-2 p-0" id="sidebar">
            @component('layouts.sidebar')
            @endcomponent
        </div>
        <div class="col-10 p-0" id="content">
            <div class="p-4 mt-5 pt-4 bg-light" style="min-height: 60vh">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
