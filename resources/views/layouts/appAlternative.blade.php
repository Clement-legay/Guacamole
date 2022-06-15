<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('img/logo2.png') }}">
    <link href="{{asset('css/app.css') }}" rel="stylesheet">
    <script src="{{asset('js/app.js') }}"></script>
    <title>@yield('title')</title>
</head>
<body>
<div id="darkener" class="modal-backdrop fade" onclick="openNav()" style="display: none"></div>
@extends('layouts.nav')
@component('layouts.sidebarAlternative')
@endcomponent

    <div class="row p-0 m-0">
        <div class="col-12 p-0" id="content">
            <div class="bg-light" style=" margin-top: 60px">  {{--                min-height: 92--}}
                @yield('content')
            </div>
        </div>
    </div>


</body>
</html>
