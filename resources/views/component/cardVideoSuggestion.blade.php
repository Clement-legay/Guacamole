<div class="row mb-4 mb-lg-2">
    <div class="col-lg-5 col-sm-12 p-0 m-0 px-lg-2" style="position:relative;">
        <a href="{{ route('watch', $video->id64()) }}">
            <img width="100%" class="img-fluid" style="width: 100%; aspect-ratio: 16/9" src="{{ $video->thumbnail() }}" alt="{{ $video->name }}">
            <div class="pb-lg-0 pe-lg-2" style="position: absolute; top: 100%; right: 0; transform: translate(0,-100%)">
                <span style="color: white; font-size: 0.8em; background: black; padding: 0 2px 2px 2px;">{{ $video->getDuration() }}</span>
            </div>
        </a>
    </div>
    <div class="col-2 d-flex d-lg-none mt-2">
        <div style="height: 40px; width: 40px; font-size: 0.5em">
            {!! $video->user()->profile_image() !!}
        </div>
    </div>
    <div class="col-lg-7 col-10">
        <div class="row justify-content-start mt-2 mt-lg-0">
            <div class="col-lg-12 px-lg-0">
                <p class="card-subtitle" style="font-size: 1em; font-weight: 600">{{ $video->title }}</p>
            </div>
            <div class="col-lg-12 px-lg-0 d-none d-lg-flex">
                <a style="text-decoration: none" href="{{ route('channel', $video->user()->id64()) }}">
                    <p class="card-text text-black-50 text-body" style="font-size: 0.8em">{{ $video->user()->username }}</p>
                </a>
            </div>
            <div class="col-lg-12 px-lg-0">
                <p class="card-text text-black-50 text-body" style="font-size: 0.8em">{{ $video->views()->count() > 1000 ? round($video->views()->count() / 1000) . 'k' : $video->views()->count() }} views • {{ $video->sinceWhen() }}</p>
            </div>
        </div>
    </div>
</div>
