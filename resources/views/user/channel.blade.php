@extends('layouts.app')

@section('title', $user->username . ' - Guacatube')

@section('content')

@if($user->banner_image)
    <div class="flex-row">
        <div class="col-12">
            <img width="100%" src="{{ $user->banner_image }}" alt="{{ $user->username }}" class="img-fluid">
        </div>
    </div>
@endif

<div class="flex-row">
    <div class="d-flex justify-content-center align-items-center">
        <div class="flex-column col-11 px-4">
            <div class="my-3 row justify-content-between">
                <div class="col-auto">
                    <div class="row align-content-center">
                        <div class="col-auto">
                            <div style="border-radius: 50%; background: {{ $user->color }}; color: white; width: 80px; height: 80px; padding-top: 17%; text-align: center; font-size: 2em">
                                {{ substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1) }}
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
                        <a href="{{ route('unsubscribe', $user->id()) }}" style="background: #9DA27A; color: white; font-weight: normal; text-transform: uppercase; padding: 8px 13px 8px 13px" class="btn">Unsubscribe</a>
                    @else
                        <a href="{{ route('subscribe', $user->id()) }}" style="background: #9DA27A; color: white; font-weight: normal; text-transform: uppercase; padding: 8px 13px 8px 13px" class="btn">Subscribe</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="flex-row">
    <div class="d-flex justify-content-center align-items-center">
        <div class="flex-column col-12 bg-light">
            <div class="flex-row px-3">
                <div class="d-flex justify-content-center align-items-center">
                    <div class="flex-column justify-content-center col-11 px-4">
                        <p class="pt-3 pb-2" style="font-weight: 500">Uploaded videos</p>
                        <div class="row">
                            @foreach($user->videos()->orderBy('created_at', 'desc')->get() as $video)
                                @component('component.cardVideoChannel', ['video' => $video])
                                @endcomponent
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
