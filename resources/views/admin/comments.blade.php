@extends('layouts.app')

@section('title', 'GuacaTube | Administration')

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
        <div class="col-12 col-lg-8">
            @can('view', \App\Comment::class)
                @foreach($comments as $comment)
                    @component('component.comment', ['comment' => $comment])@endcomponent
                @endforeach
            @else
                <div class="col-12 p-0 m-0">
                    <p>You don't have permission to view content on this page.</p>
                </div>
            @endcan
        </div>
        <div class="dropdown-divider" style="padding: 0 !important;"></div>
    </div>
@endsection
