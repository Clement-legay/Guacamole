@extends('layouts.appAlternative')

@section('title', $video->title)

@section('head')

@endsection

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

    <div class="flex-row">
        <div class="d-flex justify-content-center px-5 pt-4">
            <div class="col-8 flex-column">
                <div class="row justify-content-center">
                    <div class="col-12 p-0 m-0">
                        @component('component.playerJS', ['video' => $video])
                        @endcomponent
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
                    <div class="col-12 p-0 m-0">
                        <div class="flex-row d-flex align-items-center justify-content-between">
                            <div class="col-5 flex-column">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        @if(Auth::check() && Auth::user()->hasLikedVideo($video->id))
                                            <a class="btn" href="{{ route('deleteOpinion', base64_encode($video->id)) }}"><i class="bi bi-hand-thumbs-up-fill" style="font-size: 1.5em"></i></a>
                                            <span>{{ $video->likes()->get()->count() >= 1000 ? number_format($video->likes()->get()->count() / 1000, 0, ',', ' ') . 'k' : $video->likes()->get()->count()}}</span>
                                        @else
                                            <a class="btn" href="{{ route('like', base64_encode($video->id)) }}"><i class="bi bi-hand-thumbs-up" style="font-size: 1.5em"></i></a>
                                            <span>{{ $video->likes()->get()->count() >= 1000 ? number_format($video->likes()->get()->count() / 1000, 0, ',', ' ') . 'k' : $video->likes()->get()->count()}}</span>
                                        @endif
                                    </div>
                                    <div class="col-auto">
                                        @if(Auth::check() && Auth::user()->hasDislikedVideo($video->id))
                                            <a class="btn" href="{{ route('deleteOpinion', base64_encode($video->id)) }}"><i class="bi bi-hand-thumbs-down-fill" style="font-size: 1.5em"></i></a>
                                            <span>I don't like</span>
                                        @else
                                            <a class="btn" href="{{ route('dislike', base64_encode($video->id)) }}"><i class="bi bi-hand-thumbs-down" style="font-size: 1.5em"></i></a>
                                            <span>I don't like</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-5 flex-column">
                                <div class="card p-2">
                                    <div class="row justify-content-between">
                                        <div class="col-5">
                                            <div class="flex-row d-flex align-items-center justify-content-between p-0 m-0">
                                                <div class="col-4 flex-column p-0 m-0">
                                                    <a href="{{ route('channel', base64_encode($video->user()->first()->id)) }}" style="text-decoration: none">
                                                        <div style="height: 40px; width: 40px; font-size: 0.55em">
                                                            {!! $video->user()->first()->profile_image() !!}
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="col-8 flex-column p-0 m-0">
                                                    <div class="row justify-content-center p-0 m-0">
                                                        <div class="col-auto p-0 m-0">
                                                            <span style="font-weight: 500">{{ $video->user()->first()->username }}</span>
                                                        </div>
                                                        <div class="col-auto p-0 m-0">
                                                            <span style="font-size: 0.8em">{{ $video->user()->first()->subscribers()->get()->count() > 1000 ? round($video->user()->first()->subscribers()->get()->count() / 1000) . 'k' : $video->user()->first()->subscribers()->get()->count() }} subscribers</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            @if(Auth::check() && Auth::user()->isSubscribedTo($video->user()->first()))
                                                <a href="{{ route('unsubscribe', $video->user()->first()->id) }}" style="width: 100%; background: #9DA27A; color: white; font-weight: normal; text-transform: uppercase; padding: 8px 13px 8px 13px" class="btn">Unsubscribe</a>
                                            @else
                                                <a href="{{ route('subscribe', $video->user()->first()->id) }}" style="width: 100%; background: #9DA27A; color: white; font-weight: normal; text-transform: uppercase; padding: 8px 13px 8px 13px" class="btn">Subscribe</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <span style="font-size: 1em">{{ $video->comments()->get()->count() }} comments</span>
                            </div>
                            @auth
                                <div class="col-10">
                                    <div class="row justify-content-center p-0 m-0">
                                        <div class="col-1 p-0 m-0">
                                            <div style="height: 40px; width: 40px; font-size: 0.5em">
                                                {!! auth()->user()->profile_image() !!}
                                            </div>
                                        </div>
                                        <div class="col-11 p-0 m-0">
                                            <form action="{{ route('comment.create') }}" method="post">
                                                @method('POST')
                                                @csrf
                                                <input type="hidden" name="video_id" value="{{ $video->id() }}">
                                                <label for="{{ 'comment_' . $video->id() }}"></label>
                                                <textarea id="{{ 'comment_' . $video->id() }}" rows="2" name="comment" class="reply" placeholder="Comment {{ $video->title }}">{{ old('comment') }}</textarea>
                                                <div class="row justify-content-end p-0 m-0 pe-5">
                                                    <div class="col-auto">
                                                        <button class="btn btn-text" type="submit">SEND</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endauth
                            @foreach($video->comments()->orderBy('created_at', 'desc')->get() as $comment)
                                <div class="col-12 comment_row py-2">
                                    <div class="row justify-content-center">
                                        <div class="col-1 pt-2">
                                            <div style="height: 40px; width: 40px; font-size: 0.5em">
                                                {!! $comment->user()->first()->profile_image() !!}
                                            </div>
                                        </div>
                                        <div class="col-11 p-0 m-0">
                                            <div class="row p-0 m-0">
                                                <div class="col-12 p-0 m-0">
                                                    <p class="p-0 m-0" style="font-size: 0.9em; font-weight: 500">{{ $comment->user()->first()->username }} <span style="font-weight: 400">{{ $comment->created_at->diffForHumans() }}</span></p>
                                                </div>
                                                <div class="col-12 p-0 m-0">
                                                    <p class="p-0 m-0" style="font-size: 0.95em">{{ $comment->comment }}</p>
                                                </div>
                                                <div class="col-12 p-0 m-0">
                                                    @auth
                                                        <button class="btn btn-text me-3" onclick="answer('{{ 'reply_form_' . $comment->id() }}')" style="border: none; background: none; font-size: 0.8em; letter-spacing: -1px">ANSWER</button>
                                                    @endauth
                                                    @guest
                                                        <a class="btn btn-text me-3" href="{{ route('login') }}" style="border: none; background: none; font-size: 0.8em; letter-spacing: -1px">ANSWER</a>
                                                    @endguest
                                                    <button onclick="replies('{{ 'replies_' . $comment->id() }}')" class="btn btn-text-bis pb-1 me-3">
                                                        <span style="font-size: 0.8em; color: #065fd4;">{{ $comment->replies()->orderBy('created_at', 'desc')->get()->count() > 1 ? $comment->replies()->orderBy('created_at', 'desc')->get()->count() . ' replies' : $comment->replies()->orderBy('created_at', 'desc')->get()->count() . ' reply' }}
                                                            <i style="font-size: 0.8em" class="bi bi-chevron-down"></i>
                                                        </span>
                                                    </button>
                                                    <button class="btn btn-text-bis"><i class="bi bi-three-dots"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        @auth
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
                                        @endauth
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
                                                            @auth
                                                                <button class="btn btn-text me-3" onclick="answer('{{ 'reply_form_' . $reply->id() }}')" style="border: none; background: none; font-size: 0.8em; letter-spacing: -1px">ANSWER</button>
                                                            @endauth
                                                            @guest
                                                                <a class="btn btn-text me-3" href="{{ route('login') }}" style="border: none; background: none; font-size: 0.8em; letter-spacing: -1px">ANSWER</a>
                                                            @endguest
                                                            <button class="btn btn-text-bis"><i class="bi bi-three-dots"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @auth
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
                                            @endauth
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4 flex-column">
                <div class="row justify-content-center ms-4">
                    <div class="col-12">
                        @auth
                            @foreach(auth()->user()->suggestions(20) as $video)
                                @component('component.cardVideoSuggestion', ['video' => $video])
                                @endcomponent
                            @endforeach
                        @endauth
                        @guest
                            @foreach(\App\Models\View::countViewsAll(now()->subWeek(), 20) as $video)
                                @component('component.cardVideoSuggestion', ['video' => $video])
                                @endcomponent
                            @endforeach
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
