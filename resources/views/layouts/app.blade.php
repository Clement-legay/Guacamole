<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('img/logo2.png') }}">
    @yield('head')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>@yield('title')</title>
</head>
<body>
@extends('layouts.nav')

<div class="row p-0 m-0">
    <div class="col-2" id="sidebar">
        @if(str_starts_with(\Illuminate\Support\Facades\Request::route()->getName(), 'profile.'))
            @component('layouts.sidebarProfile')
            @endcomponent
        @elseif(str_starts_with(\Illuminate\Support\Facades\Request::route()->getName(), 'video.'))
            @component('layouts.sidebarVideo', ['video' => $video ?? null])
            @endcomponent
        @elseif(str_starts_with(\Illuminate\Support\Facades\Request::route()->getName(), 'admin.'))
            @component('layouts.sidebarAdmin')
            @endcomponent
        @else
            @component('layouts.sidebarMain')
            @endcomponent
        @endif
    </div>
    @if(Agent::isMobile())
    <div class="col-12 p-0" id="content">
    @else
    <div class="col-10 p-0" id="content">
    @endif
        <div class="@yield('background')" style="margin-top: 60px;">
            {{--                min-height: 92--}}
            @yield('content')
        </div>
    </div>
</div>
</div>
</body>
</html>
