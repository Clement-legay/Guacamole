@extends('layouts.app')

@section('title', Auth::user()->username . '\'s history')

@section('content')
    <div class="container">
        @foreach($historyVideos as $video)
            @component('component.cardVideoHistory', ['video' => $video])
            @endcomponent
        @endforeach
    </div>
@endsection
