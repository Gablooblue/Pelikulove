<script id="plyr_script" type="text/javascript">
// Change the second argument to your options:
// https://github.com/sampotts/plyr/#options
const player = new Plyr('video', { 
  captions: { 
    active: true, // show/hide subs on first play
    language: 'en' // default subs
  },
  autoplay: false,
  controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'settings', 'pip', 'airplay', 'fullscreen'],
  settings: ['captions', 'speed'],
  keyboard: { 
    focused: true, 
    global: false 
  },
});

// Expose player so it can be used from the console
window.player = player;

player.source = {
  type: 'video',
  title: 'yey',

  // define video file here
  sources: [
    { 
      //src: 'http://localhost:5000/video/1',
      src: '{{$topic->video}}',
      type: 'video/mp4',
      size: 640
    }
  ],
    
  // define thumbnail here
  poster: '{{ asset('images/obb.png') }}',

  // define subs here 
  tracks: [
    {
      kind: 'captions',
      label: 'English',
      srclang: 'en',
      src: '{{$topic->transcript}}'
    }
  ]
};

$(document).ready(function(){
  var videoSrc = $(".plyr__video-wrapper > video > source")
  var trackSrc = $(".plyr__video-wrapper > video > track")

  videoSrc[0].src = '';
  // trackSrc[0].src = '';
  videoSrc[0].remove();
  // trackSrc[0].remove();

  var thisScript = $("#plyr_script");
  thisScript.remove();
});
</script>

<script>
  window.player = player;

function timeFormatToHMMSS(time) {
  return moment.utc(time * 1000).format('H:mm:ss');
}

function getPlayerTimeData() {

  var rawTime = player.currentTime; // in secs

  var timeElapsed = timeFormatToHMMSS(rawTime);
  var timeLeft = timeFormatToHMMSS(player.duration - rawTime);

  return { 
    timeElapsed: timeElapsed,
    timeLeft: timeLeft
  };
}

function isMobile() {
  let isMobile = window.matchMedia("only screen and (max-width: 767px)").matches;

  return isMobile;
}

// get time when paused
player.on('pause', evt => {
  // console.log(getPlayerTimeData())
})

// get time when ended
player.on('ended', evt => {
  // console.log(getPlayerTimeData())
  $('#surveyLink').modal('show');
})

// get time when seeked
player.on('seeked', evt => {
  // console.log(getPlayerTimeData())
})

// On Fullscreen
player.on('enterfullscreen', evt => {
  if (isMobile()) {
    screen.orientation.lock("landscape");
  }
})

// On Exit Fullscreen
player.on('exitfullscreen', evt => {
  if (isMobile()) {
    screen.orientation.unlock();
  }
})

$(document).ready(function(){
  $( ".plyr__volume" ).prop("hidden", 0);
  $( ".plyr__control" ).prop("hidden", 0);
});

$( ".plyr" ).click(function(){
  $( ".plyr__volume" ).prop("hidden", 0);
  $( ".plyr__control" ).prop("hidden", 0);
});
</script>