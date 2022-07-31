<!-- CSS  -->
<link href="https://vjs.zencdn.net/7.2.3/video-js.css" rel="stylesheet">

<style>
    .vjs-control-bar {
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 5%, rgba(0, 0, 0, 0.5) 100%) !important;
    }

    .vjs-big-play-button {
        background: none !important;
        border: none !important;
        font-size: 11em !important;
        position: relative;
    }

    .vjs-progress-control {
        position: absolute !important;
        width: 100% !important;
        top: -20px !important;
    }

    .vjs-progress-control:hover .vjs-slider-bar::before {
        display: flex !important;
    }

    .vjs-slider-bar::before {
        color: #67875E !important;
        display: none !important;
    }

    .vjs-slider-bar {
        background-color: #67875E !important;
    }

    .vjs-load-progress > div {
        background-color: rgb(194, 194, 194) !important;

    }

    .vjs-play-progress > .vjs-time-tooltip {
        display: none !important;
    }

    .vjs-progress-holder {
        background-color: rgba(194, 194, 194, 0.60) !important;
    }

    .vjs-fullscreen-control {
        position: absolute !important;
        right: 0 !important;
    }
</style>

<!-- HTML -->
<video id='hls' class="video-js vjs-big-play-centered" data-setup='{"fluid": true}' controls preload="auto" poster="{{ $video->thumbnail() }}">
    <source type="application/x-mpegURL" src="{{ asset($video->video) }}">
</video>


{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-contrib-hls/5.14.1/videojs-contrib-hls.js"></script>--}}
<script src="https://vjs.zencdn.net/7.2.3/video.js"></script>
{{--<script src="//path/to/videojs-hls-quality-selector.min.js"></script>--}}

<script>
    let player = videojs('#hls', {
        aspectRatio: '16:9',
        // controlBar: {
        //     customControlSpacer: true,
        // }
    })
</script>
