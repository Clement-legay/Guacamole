<!-- CSS  -->
<link href="https://vjs.zencdn.net/7.2.3/video-js.css" rel="stylesheet">


<!-- HTML -->
<video id='hls-example' class="video-js vjs-big-play-centered" controls data-setup='{"fluid": true}' poster="{{ asset($video->thumbnail) }}">
    <source type="application/x-mpegURL" src="{{ asset($video->video) }}">
</video>


<!-- JS code -->
<!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
<script src="https://vjs.zencdn.net/ie8/ie8-version/videojs-ie8.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-contrib-hls/5.14.1/videojs-contrib-hls.js"></script>
<script src="https://vjs.zencdn.net/7.2.3/video.js"></script>

<script>
    let player = videojs('hls-example');
    player.play();
</script>
