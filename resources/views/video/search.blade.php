@extends('layouts.app')

@section('title', 'GuacaTube | ' . $search)
@section('search', $search)

@section('content')
    <style>
        .channel_row {
            cursor: pointer;
        }
    </style>

    <div class="row justify-content-center mx-0">
        <div class="col-lg-11">
            @if(isset($chanel))
                <div class="dropdown-divider"></div>
                <div onclick="doNav('{{ route('channel', $chanel->id64()) }}')" class="row justify-content-center channel_row">
                    <div class="col-10">
                        <div class="row d-flex align-items-center my-4">
                            <div class="col-5 col-lg-2">
                                <div style="width: 120px; height: 120px; font-size: 1.5em">
                                    {!! $chanel->profile_image() !!}
                                </div>
                            </div>
                            <div class="col-7 col-lg-8">
                                <div class="row">
                                    <div class="col-12">
                                        <p class="m-0" style="font-size: 1em; font-weight: 500">{{ $chanel->username }}</p>
                                    </div>
                                    <div class="col-12 m-0">
                                        <p class="m-0" style="font-size: 0.9em; font-weight: 400">{{ $chanel->videos()->count() }} video(s)</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="m-0" style="font-size: 0.9em; font-weight: 400">{{ $chanel->subscribers()->count() }} subscriber(s)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="d-none d-lg-flex col-lg-2">
                                @if(Auth::check() && Auth::user()->isSubscribedTo($chanel))
                                    <a href="{{ route('unsubscribe', $chanel->id64()) }}" style="width: 100%; background: #9DA27A; color: white; font-weight: normal; text-transform: uppercase; padding: 8px 13px 8px 13px" class="btn">Unsubscribe</a>
                                @else
                                    <a href="{{ route('subscribe', $chanel->id64()) }}" style="width: 100%; background: #9DA27A; color: white; font-weight: normal; text-transform: uppercase; padding: 8px 13px 8px 13px" class="btn">Subscribe</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
            @endif
            @if($videos->count() == 0)
                <div class="flex-row d-flex justify-content-center align-items-center" style="height: 60vh; overflow: auto;">
                    <div class="col-6">
                        <div class="row justify-content-center">
                            <div class="col-auto">
                                <i class="bi bi-search" style="font-size: 2em"></i>
                            </div>
                            <div class="col-12">
                                <div class="text-center" style="font-size: 1em">
                                    Aucun résultat pour la recherche : <strong style="font-size: 1.1em; font-weight: 550">{{ $search }}</strong>
                                </div>
                            </div>
                    </div>
                </div>
            @else
                @foreach($videos as $video)
                    @component('component.cardVideoSearch', ['video' => $video])
                    @endcomponent
                @endforeach
            @endif
        </div>
@endsection
