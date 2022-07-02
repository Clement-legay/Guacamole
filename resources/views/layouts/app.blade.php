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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>@yield('title')</title>
</head>
<body>
@extends('layouts.nav')

<div class="row p-0 m-0">
    <div class="col-2" id="sidebar">
        @if(Agent::isMobile())
            @component('layouts.sidebarAlternative)
            @endcomponent
        @elseif(str_starts_with(\Illuminate\Support\Facades\Request::route()->getName(), 'profile.'))
            @component('layouts.sidebarProfile')
            @endcomponent
        @elseif(str_starts_with(\Illuminate\Support\Facades\Request::route()->getName(), 'video.'))
            @component('layouts.sidebarVideo', ['video' => $video ?? null])
            @endcomponent
        @elseif(str_starts_with(\Illuminate\Support\Facades\Request::route()->getName(), 'admin.'))
            @component('layouts.sidebarAdmin')
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
