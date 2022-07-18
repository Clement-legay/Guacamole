@extends('layouts.app')

@section('title', Auth::user()->username . '\'s history')

@section('background', 'bg-light')

@section('content')
    <div class="row justify-content-center mx-0">
        <div class="col-lg-7 col-12">
            @foreach($historyVideos as $video)
                @component('component.cardVideoLiked', ['video' => $video])@endcomponent
            @endforeach
        </div>
    </div>
@endsection
