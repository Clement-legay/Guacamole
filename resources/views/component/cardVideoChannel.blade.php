<div class="col-12 col-lg-2 px-0 mx-lg-2 px-xl-2 px-lg-1 mx-lg-3 mb-4">
    <a style="text-decoration: none; color: black" href="{{ route('watch', base64_encode($video->id)) }}">
        <div class="row justify-content-start">
            <div class="col-12 col-lg-12 px-0 px-lg-0" style="position: relative">
                <img class="card-img-top" style="width: 100%; aspect-ratio: 16/9" src="{{ $video->thumbnail() }}" alt="{{ $video->name }}">
                <div class="pb-lg-2 pe-lg-2" style="position: absolute; top: 100%; right: 0; transform: translate(0,-100%)">
                    <span style="color: white; font-size: 0.8em; background: black; padding: 0 2px 2px 2px;">{{ $video->getDuration() }}</span>
                </div>
            </div>
            <div class="col-12">
                <div class="row justify-content-between pt-2 align-content-center">
                    <div class="col-12">
                        <div class="row justify-content-between px-3 px-lg-0">
                            <div class="col-2 d-flex d-lg-none">
                                <div style="width: 40px; height: 40px; font-size: 0.55em">
                                    {!! $video->user()->profile_image() !!}
                                </div>
                            </div>
                            <div class="col-10 col-lg-12">
                                <div class="row justify-content-start">
                                    <p class="card-subtitle" style="font-size: 1em">{{ $video->title }}</p>
                                </div>
                                <div class="row justify-content-start">
                                    <p style="font-size: 0.9em" class="card-text text-black-50 text-body">{{ $video->views()->count() > 1000 ? round($video->views()->count() / 1000) . 'k' : $video->views()->count() }} views • {{ $video->sinceWhen() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </a>
</div>
