<div class="col-12">
    <div class="mb-2">
        <div class="row">
            <div class="col-lg-4 col-12 p-0 p-lg-2">
                <a href="{{ route('watch', $video->id64()) }}">
                    <img class="card-img-top" style="width: 100%; aspect-ratio: 16/9" src="{{ asset($video->thumbnail) }}" alt="{{ $video->name }}">
                </a>
            </div>
            <div class="col-lg-8 col-12 p-0 p-lg-2">
                <div class="row justify-content-start justify-content-lg-between p-lg-3 align-content-center p-2">
                    <div class="col-10 col-lg-12 order-1 order-lg-0">
                        <div class="row justify-content-between">
                            <div class="col-12 ps-0">
                                <p class="card-subtitle" style="font-size: 1em">{{ $video->title }}</p>
                            </div>
                            <div class="col-12 ps-0">
                                <p class="card-text text-black-50 text-body">{{ $video->views()->count() > 1000 ? round($video->views()->count() / 1000) . 'k' : $video->views()->count() }} views • {{ $video->sinceWhen() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 col-lg-12 ps-4 ps-lg-3 mt-lg-3 order-0 order-lg-1">
                        <div class="row align-content-center">
                            <div class="col-auto p-0">
                                <a style="text-decoration: none" href="{{ route('channel', base64_encode($video->user()->id)) }}">
                                    <div style="width: 40px; height: 40px; font-size: 0.55em">
                                        {!! $video->user()->profile_image() !!}
                                    </div>
                                </a>
                            </div>
                            <div class="col-auto pt-1 mt-1 d-none d-lg-flex">
                                <a class="card-text text-black-50 text-body" style="text-decoration: none" href="{{ route('channel', base64_encode($video->user()->id)) }}">{{ $video->user()->username }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-10 col-lg-12 mt-3 order-2 order-lg-3 ps-1 d-none d-lg-flex">
                        <div class="col-12">
                            <p class="card-text text-black-50 text-body" style="font-size: 1em">{{ $video->description }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

