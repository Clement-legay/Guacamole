@extends('layouts.app')

@section('title', Auth::user()->username . '\'s likes')

@section('content')
    <div class="container">
        @foreach($likedVideos as $video)
            @component('component.cardVideoHistory', ['video' => $video])
            @endcomponent
        @endforeach
    </div>
@endsection
