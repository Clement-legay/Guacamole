<div class="col-12">
    <div class="mb-2">
        <div class="row">
            <div class="col-lg-5 col-12 p-0 p-lg-2" style="position: relative">
                <a href="{{ route('watch', $video->id64()) }}">
                    <img class="card-img-top" style="width: 100%; aspect-ratio: 16/9" src="{{ $video->thumbnail() }}" alt="{{ $video->name }}">
                    <div class="pb-lg-2 pe-lg-2" style="position: absolute; top: 100%; right: 0; transform: translate(0,-100%)">
                        <span style="color: white; font-size: 0.8em; background: black; padding: 0 2px 2px 2px;">{{ $video->getDuration() }}</span>
                    </div>
                </a>
            </div>
            <div class="col-lg-7 col-12 p-0 p-lg-2">
                <div class="row justify-content-start justify-content-lg-between py-lg-1 px-lg-2 align-content-center p-2">
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
                            <p class="card-text text-black-50 text-body" style="font-size: 1em">{{ strlen($video->description) > 50 ? substr($video->description, 0, 50) . '...' : $video->description }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

