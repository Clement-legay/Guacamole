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
        @foreach($comments as $comment)
            <div class="col-12 comment_row py-2">
                <div class="row justify-content-center">
                    <div class="col-1 pt-2">
                        <div style="height: 40px; width: 40px; font-size: 0.5em">
                            {!! $comment->user()->first()->profile_image() !!}
                        </div>
                    </div>
                    <div class="col-7 p-0 m-0">
                        <div class="row p-0 m-0">
                            <div class="col-12 p-0 m-0">
                                <p class="p-0 m-0" style="font-size: 0.9em; font-weight: 500">{{ $comment->user()->first()->username }} • {{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="col-12 p-0 m-0">
                                <p class="p-0 m-0" style="font-size: 0.8em">{{ $comment->comment }}</p>
                            </div>
                            <div class="col-12 p-0 m-0">
                                <button class="btn btn-text me-3" onclick="answer('{{ 'reply_form_' . $comment->id() }}')" style="border: none; background: none; font-size: 0.8em; letter-spacing: -1px">ANSWER</button>
                                <button onclick="replies('{{ 'replies_' . $comment->id() }}')" class="btn btn-text-bis pb-1 me-3"><span style="font-size: 0.8em">{{ $comment->replies()->orderBy('created_at', 'desc')->get()->count() }} replies <i style="font-size: 0.8em" class="bi bi-chevron-down"></i></span></button>
                                <button class="btn btn-text-bis"><i class="bi bi-three-dots"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="row justify-content-center">
                            <div class="col-4">
                                <img src="{{ asset($comment->video()->first()->thumbnail) }}" width="100%" height="auto" alt="{{ $comment->video()->first()->title }}">
                            </div>
                            <div class="col-6">
                                <p class="p-0 m-0 video_name" style="font-size: 0.9em; font-weight: 400">{{ $comment->video()->first()->title }}</p>
                            </div>
                            <div class="col-2">
                                <button style="display: none" class="btn btn-text-bis link-none"><i class="bi bi-link"></i></button>
                            </div>
                        </div>
                    </div>
                    <div id="{{ 'reply_form_' . $comment->id() }}" style="display: none" class="col-10 p-0 m-0">
                        <div class="row justify-content-start p-0 m-0">
                            <div class="col-7">
                                <div class="row justify-content-center p-0 m-0">
                                    <div class="col-1 p-0 m-0">
                                        <div style="height: 30px; width: 30px; font-size: 0.45em">
                                            {!! auth()->user()->profile_image() !!}
                                        </div>
                                    </div>
                                    <div class="col-11 p-0 m-0">
                                        <form action="{{ route('comment.create') }}" method="post">
                                            @method('POST')
                                            @csrf
                                            <input type="hidden" name="previous_id" value="{{ $comment->id() }}">
                                            <label for="{{ 'reply_' . $comment->id() }}"></label>
                                            <textarea id="{{ 'reply_' . $comment->id() }}" rows="2" class="reply" name="comment" id="comment" placeholder="Reply to {{ $comment->user()->first()->username }}">{{ old('reply') }}</textarea>
                                            <div class="row justify-content-end p-0 m-0">
                                                <div class="col-auto">
                                                    <button onclick="answer('{{ 'reply_form_' . $comment->id() }}', false)" type="button" class="btn btn-text-blue">BACK</button>
                                                </div>
                                                <div class="col-auto">
                                                    <button class="btn btn-text" type="submit">SEND</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="{{ 'replies_' . $comment->id() }}" style="display: none">
                @foreach($comment->replies()->orderBy('created_at', 'asc')->get() as $reply)
                    <div class="col-12 comment_row py-2 px-5">
                        <div class="row justify-content-center px-2">
                            <div class="col-1 pt-2">
                                <div style="height: 40px; width: 40px; font-size: 0.5em">
                                    {!! $reply->user()->first()->profile_image() !!}
                                </div>
                            </div>
                            <div class="col-10 p-0 m-0">
                                <div class="row p-0 m-0">
                                    <div class="col-12 p-0 m-0">
                                        <p class="p-0 m-0" style="font-size: 0.9em; font-weight: 500">{{ $reply->user()->first()->username }} • {{ $reply->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="col-12 p-0 m-0">
                                        <p class="p-0 m-0" style="font-size: 0.8em">{{ $reply->comment }}</p>
                                    </div>
                                    <div class="col-12 p-0 m-0">
                                        <button class="btn btn-text me-3" onclick="answer('{{ 'reply_form_' . $reply->id() }}')" style="border: none; background: none; font-size: 0.8em; letter-spacing: -1px">ANSWER</button>
                                        <button class="btn btn-text-bis"><i class="bi bi-three-dots"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="{{ 'reply_form_' . $reply->id() }}" style="display: none" class="col-10 p-0 m-0 mt-3">
                            <div class="row justify-content-center p-0 m-0">
                                <div class="col-12 ms-1 px-3">
                                    <div class="row justify-content-center p-0 m-0">
                                        <div class="col-1 p-0 m-0 pt-2">
                                            <div style="height: 40px; width: 40px; font-size: 0.5em">
                                                {!! auth()->user()->profile_image() !!}
                                            </div>
                                        </div>
                                        <div class="col-10 p-0 m-0">
                                            <form action="{{ route('comment.create') }}" method="post">
                                                @method('POST')
                                                @csrf
                                                <input type="hidden" name="previous_id" value="{{ $comment->id() }}">
                                                <label for="{{ 'reply_' . $reply->id() }}"></label>
                                                <textarea id="{{ 'reply_' . $reply->id() }}" rows="2" class="reply" name="comment" id="comment" placeholder="Reply to {{ $reply->user()->first()->username }}">{{ old('reply') }}</textarea>
                                                <div class="row justify-content-end p-0 m-0">
                                                    <div class="col-auto">
                                                        <button onclick="answer('{{ 'reply_form_' . $reply->id() }}', false)" type="button" class="btn btn-text-blue">BACK</button>
                                                    </div>
                                                    <div class="col-auto">
                                                        <button class="btn btn-text" type="submit">SEND</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
        <div class="dropdown-divider" style="padding: 0 !important;"></div>
    </div>
@endsection
