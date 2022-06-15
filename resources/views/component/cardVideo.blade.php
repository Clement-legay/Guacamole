<div class="col-3">
    <a style="text-decoration: none;" href="{{ route('watch', base64_encode($video->id)) }}">
        <div class="mb-4 p-0">
            <div class="row">
                <div class="col-12">
                    <img class="card-img-top" src="{{ $video->thumbnail }}" alt="{{ $video->name }}">
                </div>
                <div class="col-12">
                    <div class="row justify-content-between p-3 align-content-center">
                        <div class="col-3">
                            <a href="{{ route('channel', base64_encode($video->user()->first()->id)) }}" style="text-decoration: none">
                                <div style="border-radius: 50%; background: {{ $video->user()->first()->color }}; color: white; width: 40px; height: 40px; text-align: center; padding-top: 6px;">
                                        {{ substr($video->user()->first()->first_name, 0, 1) . substr($video->user()->first()->last_name, 0, 1) }}
                                </div>
                            </a>
                        </div>
                        <div class="col-9">
                            <div class="row justify-content-between">
                                <div class="col-12">
                                    <p class="card-subtitle" style="font-size: 1em">{{ $video->title }}</p>
                                </div>
                                <div class="col-12">
                                    <p class="card-text text-black-50 text-body">{{ $video->user()->first()->username }}</p>
                                </div>
                                <div class="col-12">
                                    <p class="card-text text-black-50 text-body">{{ $video->views()->count() > 1000 ? round($video->views()->count() / 1000) . 'k' : $video->views()->count() }} views • {{ $video->sinceWhen() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </a>
</div>
