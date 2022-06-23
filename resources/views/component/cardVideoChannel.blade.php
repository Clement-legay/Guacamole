<div class="col-3">
    <a style="text-decoration: none; color: black" href="{{ route('watch', base64_encode($video->id)) }}">
        <div class="mb-4 p-0">
            <div class="row">
                <div class="col-12">
                    <img class="card-img-top" src="{{ $video->thumbnail }}" alt="{{ $video->name }}">
                </div>
                <div class="col-12">
                    <div class="row justify-content-between pt-2 align-content-center">
                        <div class="col-12">
                            <div class="row justify-content-between">
                                <div class="col-12">
                                    <p class="card-subtitle" style="font-size: 1em">{{ $video->title }}</p>
                                </div>
                                <div class="col-12">
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
