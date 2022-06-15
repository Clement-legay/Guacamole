@extends('layouts.appAlternative')

@section('title', $video->title)

@section('content')
    <div class="row justify-content-center px-5 pt-4">
        <div class="col-8">
            <div class="row justify-content-center">
                <div class="col-12 p-0 m-0">
                    <video width="100%" height="100%">
                        <source src="{{ asset($video->video) }}" type="video/mp4"/>

                        Your browser does not support the video tag.

                    </video>
                </div>
                <div class="col-12 p-0 m-0">
                    <p class="p-0 m-0" style="font-weight: 500; font-size: 0.95em; color: #065fd4">
                        @foreach($video->tags()->get() as $tag)
                            <a style="text-decoration: none" href="{{ route('hashtag', $tag) }}">
                                {{ $tag->name }}
                            </a>
                        @endforeach
                    </p>
                </div>
                <div class="col-12 p-0 m-0">
                    <h3 style="font-size: 1.2em">{{ $video->title }}</h3>
                </div>
                <div class="col-12 p-0 m-0 centerThis">
                    <p style="font-size: 0.95em; color: #3a3838"><span style="color: black; font-weight: 500">{{ number_format($video->views()->count(), 0, ',', ' ') }} vues {{ $video->created_at->format('d F Y') }}</span> {{ $video->description }}</p>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="row justify-content-center">

            </div>
        </div>
    </div>
@endsection
