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
                <div class="row justify-content-center comment_row p-0 m-0">
                    <div class="col-lg-1 col-2 p-0 m-0">
                        <div style="height: 40px; width: 40px; font-size: 0.5em">
                            {!! $comment->user()->profile_image() !!}
                        </div>
                    </div>
                    <div class="col-lg-6 col-10 p-0 m-0">
                        <div class="row p-0 m-0">
                            <p class="p-0 m-0" style="font-size: 0.9em; font-weight: 500">{{ $comment->user()->username }} <span style="font-weight: 400">{{ $comment->created_at->diffForHumans() }}</span></p>
                        </div>
                        <div class="row p-0 m-0">
                            <p class="p-0 m-0" style="font-size: 0.95em">{{ $comment->comment }}</p>
                        </div>
                        <div class="row p-0 m-0">
                            <div class="col-auto p-0 m-0">
                                @auth
                                    <button class="btn btn-text me-3" onclick="answer('{{ 'reply_form_' . $comment->id64() }}')" style="border: none; background: none; font-size: 0.8em; letter-spacing: -1px">ANSWER</button>
                                @endauth
                                @guest
                                    <a class="btn btn-text me-3" href="{{ route('login') }}" style="border: none; background: none; font-size: 0.8em; letter-spacing: -1px">ANSWER</a>
                                @endguest
                            </div>
                            <div class="col-auto p-0 m-0">
                                <button onclick="replies('{{ 'replies_' . $comment->id64() }}')" class="btn btn-text-bis pb-1 me-3">
                                            <span style="font-size: 0.8em; color: #065fd4;">{{ $comment->replies()->orderBy('created_at', 'desc')->get()->count() > 1 ? $comment->replies()->orderBy('created_at', 'desc')->get()->count() . ' replies' : $comment->replies()->orderBy('created_at', 'desc')->get()->count() . ' reply' }}
                                                <i style="font-size: 0.8em" class="bi bi-chevron-down"></i>
                                            </span>
                                </button>
                            </div>
                            <div class="col-auto p-0 m-0">
                                <div class="dropdown">
                                    <button class="btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu p-0 m-0" aria-labelledby="dropdownMenuButton1">
                                        @can('update', $comment)
                                            <li><a class="dropdown-item" href="{{ route('admin.comment', $comment->id64()) }}">Edit <i class="bi bi-pencil"></i></a></li>
                                        @else
                                            <li><button class="dropdown-item" disabled>Edit <i class="bi bi-pencil"></i></button></li>
                                        @endcan
                                        @can('delete', $comment)
                                            <li><a class="dropdown-item" href="{{ route('admin.comment.delete', $comment->id64()) }}">Delete <i class="bi bi-trash-fill"></i></a></li>
                                        @else
                                            <li><button class="dropdown-item" disabled>Delete <i class="bi bi-trash-fill"></i></button></li>
                                        @endcan
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 d-lg-flex d-none">
                        <div class="row p-0 m-0">
                            <div class="col-6">
                                <img src="{{ asset($comment->video()->thumbnail) }}" style="width: 100%; aspect-ratio: 16/9" alt="{{ $comment->video()->title }}">
                            </div>
                            <div class="col-6">
                                <p class="text-body">{{ $comment->video()->title }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @auth
                    <div id="{{ 'reply_form_' . $comment->id64() }}" style="display: none">
                        <div class="row justify-content-center p-0 m-0 mt-2">
                            <div class="col-9">
                                <div class="row justify-content-center p-0 m-0">
                                    <div class="col-lg-1 col-2 p-0 m-0">
                                        <div style="height: 30px; width: 30px; font-size: 0.45em">
                                            {!! auth()->user()->profile_image() !!}
                                        </div>
                                    </div>
                                    <div class="col-lg-11 col-10 p-0 m-0">
                                        <form action="{{ route('comment.create') }}" method="post">
                                            @method('POST')
                                            @csrf
                                            <input type="hidden" name="previous_id" value="{{ $comment->id64() }}">
                                            <label for="{{ 'reply_' . $comment->id64() }}"></label>
                                            <textarea id="{{ 'reply_' . $comment->id64() }}" rows="2" class="reply" name="comment" id="comment" placeholder="Reply to {{ $comment->user()->username }}">{{ old('reply') }}</textarea>
                                            <div class="row justify-content-end p-0 m-0">
                                                <div class="col-auto mx-1">
                                                    <button onclick="answer('{{ 'reply_form_' . $comment->id64() }}', false)" type="button" class="btn btn-text-blue">BACK</button>
                                                </div>
                                                <div class="col-auto mx-1">
                                                    <button class="btn btn-text" type="submit">SEND</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endauth
                <div id="{{ 'replies_' . $comment->id64() }}" style="display: none">
                    @foreach($comment->replies()->orderBy('created_at', 'asc')->get() as $reply)
                        <div class="row justify-content-center py-2 px-5 comment_row">
                            <div class="col-lg-1 col-3 pt-2">
                                <div style="height: 40px; width: 40px; font-size: 0.5em">
                                    {!! $reply->user()->profile_image() !!}
                                </div>
                            </div>
                            <div class="col-lg-10 col-9 p-0 m-0">
                                <div class="row p-0 m-0">
                                    <p class="p-0 m-0" style="font-size: 0.9em; font-weight: 500">{{ $reply->user()->username }} • {{ $reply->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="col-12 p-0 m-0">
                                    <p class="p-0 m-0" style="font-size: 0.8em">{{ $reply->comment }}</p>
                                </div>
                                <div class="col-12 p-0 m-0">
                                    <div class="row d-flex align-items-center justify-content-start">
                                        <div class="col-auto">
                                            <button class="btn btn-text me-3" onclick="answer('{{ 'reply_form_' . $reply->id64() }}')" style="border: none; background: none; font-size: 0.8em; letter-spacing: -1px">ANSWER</button>
                                        </div>
                                        <div class="col-auto">
                                            <div class="dropdown">
                                                <button class="btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots"></i>
                                                </button>
                                                <ul class="dropdown-menu p-0 m-0" aria-labelledby="dropdownMenuButton1">
                                                    @can('update', $comment)
                                                        <li><a class="dropdown-item" href="{{ route('admin.comment', $comment->id64()) }}">Edit <i class="bi bi-pencil"></i></a></li>
                                                    @else
                                                        <li><button class="dropdown-item" disabled>Edit <i class="bi bi-pencil"></i></button></li>
                                                    @endcan
                                                    @can('delete', $comment)
                                                        <li><a class="dropdown-item" href="{{ route('admin.comment.delete', $comment->id64()) }}">Delete <i class="bi bi-trash-fill"></i></a></li>
                                                    @else
                                                        <li><button class="dropdown-item" disabled>Delete <i class="bi bi-trash-fill"></i></button></li>
                                                    @endcan
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @auth
                            <div id="{{ 'reply_form_' . $reply->id64() }}" style="display: none">
                                <div class="row justify-content-center py-2 px-5">
                                    <div class="col-lg-1 col-3 pt-2">
                                        <div style="height: 40px; width: 40px; font-size: 0.5em">
                                            {!! auth()->user()->profile_image() !!}
                                        </div>
                                    </div>
                                    <div class="col-lg-10 col-9 p-0 m-0">
                                        <form action="{{ route('comment.create') }}" method="post">
                                            @method('POST')
                                            @csrf
                                            <input type="hidden" name="previous_id" value="{{ $comment->id64() }}">
                                            <label for="{{ 'reply_' . $reply->id64() }}"></label>
                                            <textarea id="{{ 'reply_' . $reply->id64() }}" rows="2" class="reply" name="comment" id="comment" placeholder="Reply to {{ $reply->user()->username }}">{{ old('reply') }}</textarea>
                                            <div class="flex-row d-flex justify-content-end p-0 m-0">
                                                <div class="flex-column col-auto mx-1">
                                                    <button onclick="answer('{{ 'reply_form_' . $reply->id64() }}', false)" type="button" class="btn btn-text-blue">BACK</button>
                                                </div>
                                                <div class="flex-column col-auto mx-1">
                                                    <button class="btn btn-text" type="submit">SEND</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endauth
                    @endforeach
                </div>
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
