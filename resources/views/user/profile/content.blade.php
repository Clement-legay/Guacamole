@extends('layouts.app')

@section('title', 'Your Content')

@section('content')

    <style>
        .video_row:hover {
            background-color: #f5f5f5;
            cursor: pointer;
        }
    </style>

    <h3>Contenu de la chaîne</h3>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Video</th>
            <th scope="col"></th>
            <th scope="col">Visibility</th>
            <th scope="col">Date</th>
            <th scope="col">Views</th>
            <th scope="col">Comments</th>
            <th scope="col">% Likes</th>
        </tr>
        </thead>
        <tbody>
            @foreach(auth()->user()->videos()->orderBy('created_at', 'desc')->get() as $video)
            <tr onclick="doNav('{{ route('video.details', base64_encode($video->id)) }}')" class="video_row">
                <th scope="row">{{ $video->id }}</th>
                <td>
                    <img width="150" height="84" src="{{ asset($video->thumbnail) }}" alt="{{ $video->title }}">
                </td>
                <td>
                    <p>{{ $video->title }}</p>
                    <p>{{ $video->description }}</p>
                </td>
                <td>{{ $video->type }}</td>
                <td>{{ $video->created_at->format('d F Y') }}</td>
                <td>{{ $video->views()->get()->count() }}</td>
                <td>{{ $video->comments()->get()->count() }}</td>
                <td>{{ $video->likes()->get()->count() > 0 ? $video->likes()->get()->count() / ($video->likes()->get()->count() + $video->dislikes()->get()->count()) * 100 : 0}}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection
