<div class="row mb-4">
    <div class="col-lg-5 col-sm-12">
        <a href="{{ route('watch', $video->id()) }}">
            <img width="100%" class="img-fluid" src="{{ asset($video->thumbnail) }}" alt="{{ $video->name }}">
        </a>
    </div>
    <div class="col-lg-7 col-sm-12">
        <div class="row justify-content-between">
            <p class="card-subtitle" style="font-size: 1em; font-weight: 600">{{ $video->title }}</p>
        </div>
        <div class="row justify-content-between">
            <a style="text-decoration: none" href="{{ route('channel', $video->user()->id()) }}">
                <p class="card-text text-black-50 text-body" style="font-size: 0.8em">{{ $video->user()->username }}</p>
            </a>
        </div>
        <div class="row">
            <p class="card-text text-black-50 text-body" style="font-size: 0.8em">{{ $video->views()->count() > 1000 ? round($video->views()->count() / 1000) . 'k' : $video->views()->count() }} views • {{ $video->sinceWhen() }}</p>
        </div>
    </div>
</div>
