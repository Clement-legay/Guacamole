<div class="row justify-content-center comment_row p-0 m-0">
    <div class="col-lg-1 col-2 p-0 m-0">
        <div style="height: 40px; width: 40px; font-size: 0.5em">
            {!! $comment->user()->profile_image() !!}
        </div>
    </div>
    <div class="col-lg-11 col-10 p-0 m-0">
        <div class="row p-0 m-0">
            <p class="p-0 m-0" style="font-size: 0.9em; font-weight: 500">{{ $comment->user()->username }} <span style="font-weight: 400">{{ $comment->created_at->diffForHumans() }}</span></p>
        </div>
        <div class="row p-0 m-0">
            <p class="p-0 m-0" style="font-size: 0.95em">{{ $comment->comment }}</p>
        </div>
        <div class="row p-0 m-0">
            <div class="col-auto p-0 m-0">
                @auth
                    @can('create', App\Comment::class)
                        <button class="btn btn-text me-3" onclick="answer('{{ 'reply_form_' . $comment->id64() }}')" style="border: none; background: none; font-size: 0.8em; letter-spacing: -1px">ANSWER</button>
                    @else
                        <button class="btn btn-text me-3" disabled style="border: none; background: none; font-size: 0.8em; letter-spacing: -1px">ANSWER</button>
                    @endcan
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
                <button class="btn btn-text-bis"><i class="bi bi-three-dots"></i></button>
            </div>
        </div>
    </div>
</div>
@auth
    @can('create', App\Comment::class)
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
    @endcan
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
                    @auth
                        @can('create', App\Comment::class)
                            <button class="btn btn-text me-3" onclick="answer('{{ 'reply_form_' . $reply->id64() }}')" style="border: none; background: none; font-size: 0.8em; letter-spacing: -1px">ANSWER</button>
                        @else
                            <button class="btn btn-text me-3" disabled style="border: none; background: none; font-size: 0.8em; letter-spacing: -1px">ANSWER</button>
                        @endcan
                    @endauth
                    @guest
                        <a class="btn btn-text me-3" href="{{ route('login') }}" style="border: none; background: none; font-size: 0.8em; letter-spacing: -1px">ANSWER</a>
                    @endguest
                    <button class="btn btn-text-bis"><i class="bi bi-three-dots"></i></button>
                </div>
            </div>
        </div>
        @auth
            @can('create', App\Comment::class)
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
            @endcan
        @endauth
    @endforeach
</div>
