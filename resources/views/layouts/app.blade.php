<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('img/logo2.png') }}">
    @yield('head')
    <link href="{{asset('css/app.css') }}" rel="stylesheet">
    <script src="{{asset('js/app.js') }}"></script>
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
            @else
                @component('layouts.sidebar')
                @endcomponent
            @endif
        </div>
        <div class="col-10 p-0" id="content">
            <div class="@yield('background')" style="margin-top: 60px;">
{{--                min-height: 92--}}
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
