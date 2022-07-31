<div class="col-lg-3 col-12 col-xl-2 px-2">
    <a style="text-decoration: none;" href="{{ route('watch', ['video' => $video->id64()])}}">
        <div class="mb-4 p-0">
            <div class="row">
                <div class="col-12" id="video_player{{ $video->id }}" style="position: relative">
                    <img class="card-img-top" style="width: 100%; aspect-ratio: 16/9" src="{{ $video->thumbnail() }}" alt="{{ $video->name }}">
                    <div class="" style="position: absolute; top: 100%; right: 0; transform: translate(0,-100%)">
                        <span style="color: white; font-size: 0.8em; background: black; padding: 0 2px 2px 2px;">{{ $video->getDuration() }}</span>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row justify-content-between p-3 align-content-center">
                        <div class="col-3">
                            <a href="{{ route('channel', base64_encode($video->user()->id)) }}" style="text-decoration: none">
                                <div style="width: 40px; height: 40px; font-size: 0.55em">
                                    {!! $video->user()->profile_image() !!}
                                </div>
                            </a>
                        </div>
                        <div class="col-9">
                            <div class="row justify-content-between">
                                <div class="col-12">
                                    <p class="card-subtitle" style="font-size: 1em">{{ $video->title }}</p>
                                </div>
                                <div class="col-12">
                                    <p class="card-text text-black-50 text-body">{{ $video->user()->username }}</p>
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


{{--<script defer>--}}
{{--    let player{{ $video->id }} = null--}}
{{--    $('#video_player{{ $video->id }}').on({--}}
{{--        "mouseenter" : function() {--}}

{{--            let video = document.getElementById('video_player{{ $video->id }}');--}}
{{--            let img = video.getElementsByTagName('img');--}}

{{--            img[0].style.display = 'none';--}}
{{--            video.innerHTML = "<video id='hls{{ $video->id }}' class='video-js vjs-big-play-centered vjs-16-9' data-setup=\"{'fluid': true, 'mute': true}\" controls preload='true' poster='{{ $video->thumbnail() }}'> <source type='application/x-mpegURL' src='{{ asset($video->video) }}'> </video>"--}}
{{--            player{{ $video->id }} = videojs('hls{{ $video->id }}', {aspectRatio: '16:9', autoplay: true})--}}

{{--            player{{ $video->id }}.ready(function() {--}}
{{--                    let promise = player.play();--}}

{{--                    if (promise !== undefined) {--}}
{{--                        promise.then(function() {--}}
{{--                            // Autoplay started!--}}
{{--                        }).catch(function(error) {--}}
{{--                            // Autoplay was prevented.--}}
{{--                        });--}}
{{--                    }--}}
{{--                },--}}
{{--            )},--}}
{{--        "mouseleave" : function() {--}}
{{--            player{{ $video->id }}.dispose();--}}
{{--            let video = document.getElementById('video_player{{ $video->id }}');--}}
{{--            let img = video.getElementsByTagName('img')--}}
{{--            video.innerHTML = "";--}}
{{--            video.innerHTML = "<img class='card-img-top' style='width: 100%; aspect-ratio: 16/9' src='{{ $video->thumbnail() }}' alt='{{ $video->name }}'>";--}}
{{--            img[0].style.display = 'flex';--}}
{{--        }--}}
{{--    });--}}
{{--</script>--}}
