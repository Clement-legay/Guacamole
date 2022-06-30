<div class="col-12">
    <div class="mb-4 p-0">
        <div class="row">
            <div class="col-5">
                <a href="{{ route('watch', $video->id()) }}">
                    <img width="100%" class="img-fluid" src="{{ asset($video->thumbnail) }}" alt="{{ $video->name }}">
                </a>
            </div>
            <div class="col-7">
                <div class="row justify-content-between align-content-center">
                    <div class="col-12">
                        <div class="row justify-content-between">
                            <div class="col-12">
                                <p class="card-subtitle" style="font-size: 1em; font-weight: 600">{{ $video->title }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row align-content-center">
                            <div class="col-auto">
                                <a style="text-decoration: none" href="{{ route('channel', $video->user()->id()) }}">
                                    <p class="card-text text-black-50 text-body" style="font-size: 0.8em">{{ $video->user()->username }}</p>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row align-content-center">
                            <div class="col-12">
                                <p class="card-text text-black-50 text-body" style="font-size: 0.8em">{{ $video->views()->count() > 1000 ? round($video->views()->count() / 1000) . 'k' : $video->views()->count() }} views • {{ $video->sinceWhen() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
