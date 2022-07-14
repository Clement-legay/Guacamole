@extends('layouts.app')

@section('title', $user->username . ' - Guacatube')

@section('content')

@if($user->banner_image)
    <div class="row">
        <div class="col-12">
            <img width="100%" src="{{ asset($user->banner_image) }}" alt="{{ $user->username }}" class="img-fluid">
        </div>
    </div>
@endif


<div class="row justify-content-center align-items-center">
    <div class="col-xl-9 col-lg-11 col-11 px-4">
        <div class="my-3 row justify-content-between">
            <div class="col-auto px-0">
                <div class="row align-content-center">
                    <div class="col-auto">
                        <div style="width: 80px; height: 80px; font-size: 1.1em">
                            {!! $user->profile_image() !!}
                        </div>
                    </div>
                    <div class="col-auto pt-2">
                        <p class="p-0 m-0" style="font-size: 1.5em">{{ $user->username }}</p>
                        <p class="p-0 m-0 text-black-50 card-text text-body" style="font-size: 1.2em"> {{ $user->subscribers()->count() > 1000 ? $user->subscribers()->count() / 1000 . 'k' : $user->subscribers()->count() }} subscribers</p>
                    </div>
                </div>
            </div>
            <div class="col-auto pt-3">
                @if(Auth::check() && Auth::user()->isSubscribedTo($user))
                    <a href="{{ route('unsubscribe', $user->id64()) }}" style="background: #9DA27A; color: white; font-weight: normal; text-transform: uppercase; padding: 8px 13px 8px 13px" class="btn">Unsubscribe</a>
                @else
                    <a href="{{ route('subscribe', $user->id64()) }}" style="background: #9DA27A; color: white; font-weight: normal; text-transform: uppercase; padding: 8px 13px 8px 13px" class="btn">Subscribe</a>
                @endif
            </div>
        </div>
    </div>
</div>


<div class="row justify-content-center align-items-center bg-light">
    <div class="col-lg-11 col-xl-9 col-12 px-4">
        <p class="pt-3 pb-2" style="font-weight: 500">Uploaded videos</p>
        <div class="row">
            @foreach($user->videos()->where('type', 'public')->where('status', 'online')->orderBy('created_at', 'desc')->get() as $video)
                @component('component.cardVideoChannel', ['video' => $video])
                @endcomponent
            @endforeach
        </div>
    </div>
</div>

@endsection
