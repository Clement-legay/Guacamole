@extends('layouts.app')

@section('title', 'Dashboard')

@section('background', 'bg-light p-4')

@section('content')
    <h3 class="mb-3">Contenu de la chaîne</h3>

    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Chanel's analytics data</h5>

                    <div class="row mt-3 mb-5">
                        <div class="col-auto">
                            <span class="p-0 m-0">Actual subscribers</span>
                            <br>
                            <span class="p-0 m-0" style="font-size: 2em; font-weight: 600">{{ auth()->user()->subscribers()->get()->count() }}</span>
                        </div>
                    </div>

                    <div class="dropdown-divider"></div>

                    <h6 class="card-subtitle">Last views summary</h6>
                    <div class="row mb-3">
                        <div class="col-auto mb-3">
                            <span class="p-0 m-0" style="font-size: 0.8em">28 last days</span>
                        </div>
                        <div class="col-12">
                            <div class="row justify-content-between">
                                <div class="col-auto">
                                    <span class="p-0 m-0" style="font-size: 1em">Views</span>
                                </div>
                                <div class="col-auto">
                                    <span class="p-0 m-0" style="font-size: 1em">{{ auth()->user()->getChanelViews(now()->subDays(28), now()) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row justify-content-between">
                                <div class="col-auto">
                                    <span class="p-0 m-0" style="font-size: 1em">Time Watched</span>
                                </div>
                                <div class="col-auto">
                                    <span class="p-0 m-0" style="font-size: 1em">{{ auth()->user()->getChanelTimeWatched(now()->subDays(28), now()) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown-divider"></div>

                    <h6 class="card-subtitle mt-2">Most viewed videos</h6>
                    <div class="row mb-3">
                        <div class="col-auto mb-3">
                            <span class="p-0 m-0" style="font-size: 0.8em">All time - Views</span>
                        </div>
                        @if(auth()->user()->videos()->count() > 0)
                            @foreach(auth()->user()->mostViewedVideos(3)->get() as $video)
                                <div class="col-12">
                                    <div class="row justify-content-between">
                                        <div class="col-auto">
                                            <span class="p-0 m-0" style="font-size: 1em">{{ $video->title }}</span>
                                        </div>
                                        <div class="col-auto">
                                            <span class="p-0 m-0" style="font-size: 1em">{{ $video->views()->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <div class="row justify-content-between">
                                    <div class="col-auto">
                                        <span class="p-0 m-0" style="font-size: 1em">No video found</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title p-0 m-0">Last subscribers</h5>
                    <span class="p-0 m-0" style="font-size: 0.8em">Since your chanel's creation</span>

                    <div class="row mt-3">
                        @foreach(auth()->user()->subscribers()->selectRaw('users.*, subscribes.created_at as subscribed_at')->orderBy('subscribed_at', 'desc')->take(5)->get() as $subscriber)
                            <div class="col-12 mb-2">
                                <div class="row justify-content-start">
                                    <div class="col-auto">
                                        <div style="width: 40px; height: 40px; font-size: 0.5em">
                                            {!! $subscriber->profile_image() !!}
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <span class="p-0 m-0" style="font-size: 1em">{{ $subscriber->username }}</span>
                                        <br>
                                        <span class="p-0 m-0" style="font-size: 0.8em">{{ $subscriber->subscribers()->get()->count() }} subs</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-12">
                            <button style="font-size: 1.2em; font-weight: 600; text-decoration: none !important; color: #065fd3" class="btn btn-">See all</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title p-0 m-0">Under Coding</h5>
                </div>
            </div>
        </div>
    </div>
@endsection
