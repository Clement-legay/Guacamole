<div class="col-lg-3 col-12 col-xl-2 px-2">
    <a style="text-decoration: none;" href="{{ route('watch', ['video' => $video->id64()])}}">
        <div class="mb-4 p-0">
            <div class="row">
                <div class="col-12" id="video_player{{ $video->id }}">
                    <img class="card-img-top" style="width: 100%; aspect-ratio: 16/9" src="{{ asset($video->thumbnail) }}" alt="{{ $video->name }}">
                </div>
                <div class="col-12">
                    <div class="row justify-content-between p-3 align-content-center">
                        <div class="col-3">
                            <a href="{{ route('channel', base64_encode($video->user()->id)) }}" style="text-decoration: none">
                                <div style="border-radius: 50%; background: {{ $video->user()->color }}; color: white; width: 40px; height: 40px; text-align: center; padding-top: 6px;">
                                    {{ substr($video->user()->first_name, 0, 1) . substr($video->user()->last_name, 0, 1) }}
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
{{--            video.innerHTML = "<video id='hls{{ $video->id }}' class='video-js vjs-big-play-centered vjs-16-9' data-setup=\"{'fluid': true, 'mute': true}\" controls preload='true' poster='{{ asset($video->thumbnail) }}'> <source type='application/x-mpegURL' src='{{ asset($video->video) }}'> </video>"--}}
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
{{--            video.innerHTML = "<img class='card-img-top' style='width: 100%; aspect-ratio: 16/9' src='{{ asset($video->thumbnail) }}' alt='{{ $video->name }}'>";--}}
{{--            img[0].style.display = 'flex';--}}
{{--        }--}}
{{--    });--}}
{{--</script>--}}
