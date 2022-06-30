<!-- CSS  -->
<link href="https://vjs.zencdn.net/7.2.3/video-js.css" rel="stylesheet">


<!-- HTML -->
<video id='hls' class="video-js vjs-big-play-centered" controls preload="auto" data-setup='{"fluid": true}' poster="{{ asset($video->thumbnail) }}">
    <source type="application/x-mpegURL" src="{{ asset($video->video) }}">
</video>


<script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-contrib-hls/5.14.1/videojs-contrib-hls.js"></script>
<script src="https://vjs.zencdn.net/7.2.3/video.js"></script>

<script>
    let player = videojs('hls');
</script>
