@extends('layouts.app')

@section('title', $video->title . ' | Comments')

@section('background', 'p-4')

@section('content')

    <style>
        .comment_row:hover {
            background-color: #f5f5f5;
            cursor: pointer;
        }

        .comment_row:hover .video_name {
            color: #065fd4;
        }

        .comment_row:hover .link-none {
            display: block;
        }

        .btn-text-blue {
            border: none;
            background: none;
            font-weight: 600;
            font-size: 0.95em;
            letter-spacing: -1px;
            padding: 0;
            color: #065fd4;
        }

        .btn-text {
            border: none;
            background: none;
            font-weight: 600;
            font-size: 0.95em;
            letter-spacing: -1px;
            padding: 0;
        }

        .btn-text-bis {
            border: none;
            background: none;
            padding: 0;
        }

        .btn-text:hover {
            color: #065fd4;
        }

        .btn-text-bis:hover {
            color: grey;
        }

        .reply {
            width: 95%;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            font-size: 0.95em;
            resize: none;
        }
    </style>

    <script>
        function answer(id, open=true) {
            if(open) {
                document.getElementById(id).style.display = 'block';
            } else {
                document.getElementById(id).style.display = 'none';
            }
        }

        function replies(id) {
            if (document.getElementById(id).style.display === 'none') document.getElementById(id).style.display = 'block';
            else document.getElementById(id).style.display = 'none';

        }
    </script>

    <h3>Comments</h3>

    <div class="row justify-content-center pt-4">
        <div class="dropdown-divider" style="padding: 0 !important;"></div>
        @foreach($video->comments()->orderBy('created_at', 'desc')->get() as $comment)
            @component('component.comment', ['comment' => $comment])@endcomponent
        @endforeach
        <div class="dropdown-divider" style="padding: 0 !important;"></div>
    </div>

@endsection
