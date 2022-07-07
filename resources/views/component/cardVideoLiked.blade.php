<div class="col-12">
    <div class="mb-4 p-0">
        <div class="row">
            <div class="col-4">
                <a href="{{ route('watch', $video->id()) }}">
                    <img class="card-img-top" style="width: 100%; aspect-ratio: 16/9" src="{{ asset($video->thumbnail) }}" alt="{{ $video->name }}">
                </a>
            </div>
            <div class="col-8">
                <div class="row justify-content-between p-3 align-content-center">
                    <div class="col-12">
                        <div class="row justify-content-between">
                            <div class="col-12">
                                <p class="card-subtitle" style="font-size: 1em">{{ $video->title }}</p>
                            </div>
                            <div class="col-12">
                                <p class="card-text text-black-50 text-body">{{ $video->views()->count() > 1000 ? round($video->views()->count() / 1000) . 'k' : $video->views()->count() }} views • {{ $video->sinceWhen() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 ms-3 mt-3">
                        <div class="row align-content-start">
                            <div class="col-auto p-0">
                                <a style="text-decoration: none" href="{{ route('channel', base64_encode($video->user()->id)) }}">
                                    <div style="width: 40px; height: 40px; font-size: 0.55em">
                                        {!! $video->user()->profile_image() !!}
                                    </div>
                                </a>
                            </div>
                            <div class="col-auto pt-1 mt-1">
                                <a class="card-text text-black-50 text-body" style="text-decoration: none" href="{{ route('channel', base64_encode($video->user()->id)) }}">{{ $video->user()->username }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="col-12">
                            <p class="card-text text-black-50 text-body" style="font-size: 1em">{{ $video->description }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
