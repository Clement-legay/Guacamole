<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('img/logo2.png') }}">
    <link href="{{asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>@yield('title')</title>
</head>
<body>
<div id="darkener" class="modal-backdrop fade" onclick="openNav()" style="display: none"></div>
@extends('layouts.nav')
@component('layouts.sidebarMainAlt')
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
