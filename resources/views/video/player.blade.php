@extends('layouts.appAlternative')

@section('title', $video->title)

@section('head')
    <script src="{{ asset('js/comments.js') }}"></script>
    <script src="{{ asset('js/player.js') }}"></script>
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

    <div>
        <div class="row justify-content-center p-0 m-0 px-lg-5 pt-lg-4">
            <div class="col-lg-8 col-12">
                <div class="row justify-content-center">
                    @component('component.playerJS', ['video' => $video])
                    @endcomponent
                </div>
                <div class="row">
                    <p class="p-0 m-0 d-none d-lg-block" style="font-weight: 500; font-size: 0.95em">
                        @foreach($video->tags()->get() as $tag)
                            <a style="text-decoration: none" href="{{ route('hashtag', $tag) }}">
                                {{ $tag->name }}
                            </a>
                        @endforeach
                    </p>
                </div>
                <div class="row px-2 pt-2 px-lg-0 pt-lg-0">
                    <h3 class="p-0 m-0" style="font-size: 1.2em">{{ $video->title }}</h3>
                </div>
                <div class="row justify-content-start px-2 pt-2 px-lg-0 pt-lg-0">
                    <p class="p-0 m-0" style="font-size: 0.95em; color: #3a3838"><span style="color: black; font-weight: 500">{{ number_format($video->views()->count(), 0, ',', ' ') }} vues {{ $video->created_at->format('d F Y') }}</span> {{ $video->description }}</p>
                </div>
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-lg-6 col-12">
                        <div class="row align-items-center justify-content-lg-start justify-content-center">
                            <div class="col-auto">
                                @if(Auth::check() && Auth::user()->hasLikedVideo($video->id64()))
                                    <a class="btn" href="{{ route('deleteOpinion', $video->id64()) }}"><i class="bi bi-hand-thumbs-up-fill" style="font-size: 1.5em"></i></a>
                                    <span>{{ $video->likes()->get()->count() >= 1000 ? number_format($video->likes()->get()->count() / 1000, 0, ',', ' ') . 'k' : $video->likes()->get()->count()}}</span>
                                @else
                                    <a class="btn" href="{{ route('like', $video->id64()) }}"><i class="bi bi-hand-thumbs-up" style="font-size: 1.5em"></i></a>
                                    <span>{{ $video->likes()->get()->count() >= 1000 ? number_format($video->likes()->get()->count() / 1000, 0, ',', ' ') . 'k' : $video->likes()->get()->count()}}</span>
                                @endif
                            </div>
                            <div class="col-auto">
                                @if(Auth::check() && Auth::user()->hasDislikedVideo($video->id64()))
                                    <a class="btn" href="{{ route('deleteOpinion', $video->id64()) }}"><i class="bi bi-hand-thumbs-down-fill" style="font-size: 1.5em"></i></a>
                                    <span>I don't like</span>
                                @else
                                    <a class="btn" href="{{ route('dislike', $video->id64()) }}"><i class="bi bi-hand-thumbs-down" style="font-size: 1.5em"></i></a>
                                    <span>I don't like</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12 p-0 m-0">
                        <div class="card p-2">
                            <div class="row justify-content-between">
                                <div class="col-6">
                                    <div class="row align-items-center justify-content-between p-0 m-0">
                                        <div class="col-4 p-0 m-0">
                                            <a href="{{ route('channel', $video->user()->id64()) }}" style="text-decoration: none">
                                                <div style="height: 40px; width: 40px; font-size: 0.55em">
                                                    {!! $video->user()->profile_image() !!}
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-8 p-0 m-0">
                                            <div class="row justify-content-center p-0 m-0">
                                                <div class="col-12 p-0 m-0">
                                                    <span style="font-weight: 500">{{ $video->user()->username }}</span>
                                                </div>
                                                <div class="col-12 p-0 m-0">
                                                    <span style="font-size: 0.8em">{{ $video->user()->subscribers()->get()->count() > 1000 ? round($video->user()->subscribers()->get()->count() / 1000) . 'k' : $video->user()->subscribers()->get()->count() }} subscribers</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-5">
                                    @if(Auth::check() && Auth::user()->isSubscribedTo($video->user()))
                                        <a href="{{ route('unsubscribe', $video->user()->id64()) }}" style="width: 100%; background: #9DA27A; color: white; font-weight: normal; text-transform: uppercase; padding: 8px 13px 8px 13px" class="btn">Unsubscribe</a>
                                    @else
                                        <a href="{{ route('subscribe', $video->user()->id64()) }}" style="width: 100%; background: #9DA27A; color: white; font-weight: normal; text-transform: uppercase; padding: 8px 13px 8px 13px" class="btn">Subscribe</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dropdown-divider m-0 my-2 p-0 d-flex d-lg-none"></div>
                <div class="row justify-content-start my-2">
                    <span style="font-size: 1em">Comments {{ $video->comments()->get()->count() }}</span>
                </div>

                @auth
                    <div class="row justify-content-start p-0 m-0">
                        <div class="col-lg-1 col-2 p-0 m-0">
                            <div style="height: 40px; width: 40px; font-size: 0.5em">
                                {!! auth()->user()->profile_image() !!}
                            </div>
                        </div>
                        <div class="col-lg-11 col-10 p-0 m-0">
                            <form action="{{ route('comment.create') }}" method="post">
                                @method('POST')
                                @csrf
                                <input type="hidden" name="video_id" value="{{ $video->id64() }}">
                                <label for="{{ 'comment_' . $video->id64() }}"></label>
                                <textarea id="{{ 'comment_' . $video->id64() }}" rows="2" name="comment" class="reply" placeholder="Comment {{ $video->title }}">{{ old('comment') }}</textarea>
                                <div class="row justify-content-end p-0 m-0 pe-lg-5">
                                    <div class="col-auto">
                                        <button class="btn btn-text" type="submit">SEND</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endauth
                @foreach($video->comments()->orderBy('created_at', 'desc')->get() as $comment)
                    @component('component.comment', ['comment' => $comment])@endcomponent
                @endforeach
            </div>
            <div class="dropdown-divider m-0 my-3 p-0 d-flex d-lg-none"></div>
            <div class="col-lg-4 col-12 ps-lg-4">
                <div class="row justify-content-center">
                    <div class="col-12">
                        @auth
                            @foreach(auth()->user()->suggestedVideos(20) as $video)
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
    <script>
        function setTimeWatchedPlayer(time) {
            player.currentTime(time);
            player.posterImage.hide();
        }

        function setTimeWatchedDB(url) {
            $.ajax({
                url: url,
                type: 'PUT',
                data: {
                    time: player.currentTime()
                },
                success: function(data) {
                    console.log(data);
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }

        function getTimeWatched() {
            return player.currentTime();
        }

        $('body').ready(function () {
            player.ready(function() {
                if ({{ $view->time_watched }} > 0) {
                    setTimeWatchedPlayer({{ $view->time_watched }});
                }
                    let promise = player.play();

                    if (promise !== undefined) {
                        promise.then(function() {
                            // Autoplay started!
                        }).catch(function(error) {
                            // Autoplay was prevented.
                        });
                    }
                },
            )

            window.addEventListener('beforeunload', function() {
                setTimeWatchedDB('{{ route('API_views', $view->id64()) }}');
            });
        });

        function answer(id, open=true) {
            console.log(document.getElementById(id).style.display);
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
@endsection
