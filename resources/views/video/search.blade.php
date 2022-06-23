@extends('layouts.app')

@section('title', 'GuacaTube | ' . $search)
@section('search', $search)

@section('content')
    <div class="container">
        @foreach($videos as $video)
            @component('component.cardVideoSearch', ['video' => $video])
            @endcomponent
        @endforeach
    </div>
@endsection
