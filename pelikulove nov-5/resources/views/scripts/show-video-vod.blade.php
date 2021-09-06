<script id="plyr_script" type="text/javascript">
// Change the second argument to your options:
// https://github.com/sampotts/plyr/#options
const player = new Plyr('video', { 
  captions: { 
    active: true, // show/hide subs on first play
    language: 'en' // default subs
  },
  autoplay: true,
  controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'settings', 'pip', 'airplay', 'fullscreen'],
  settings: ['captions', 'speed'], 
  keyboard: { 
    focused: true, 
    global: true 
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
      @php 
        $implodeVideo = explode('.', $vod->video);  
        $implodeExtension = str_split($implodeVideo[sizeOf($implodeVideo)-1]);        
      @endphp
      src: '{{$vod->video}}',
      // src: '@foreach($implodeVideo as $videoPiece) @if (!$loop->last) "$videoPiece" + "." + @else @foreach ($implodeExtension as $extPiece) "$extPiece" @if(!$loop->last) + @endif @endforeach @endif @endforeach',
      type: 'video/mp4',
      size: 576
    }
  ],
  
  // define thumbnail here
  poster: "{{ asset('images/vods/' . $vod->thumbnail) }}",

  // define subs here
  tracks: [
    {
      kind: 'captions',
      label: 'English',
      srclang: 'en',
      src: '{{$vod->transcript}}'
    }
  ], 
  
  @if (isset($vod->preview_thumbnails))  
  previewThumbnails: { 
    enabled: true,    
    src: "{{$vod->preview_thumbnails}}"    
  }
  @endif
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

// // get time when paused
// player.on('pause', evt => {
//   console.log(getPlayerTimeData());
//   console.log(player.buffered);
// })

// // get time when ended
// player.on('ended', evt => {
//   console.log(getPlayerTimeData());
// })

// // get time when seeked
// player.on('seeked', evt => {
//   console.log(getPlayerTimeData());
// })

// Send Log to DB on Video End
var timestamp = 0;

player.on('ended', evt => {
  // var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  // var vod_id = '{{$vod->id}}';

  // if (moment().diff(timestamp, 'minutes') > 0) {
  //   $.ajax({
  //     url:"/analytics/vod/end", 
  //     type: "POST", 
  //     dataType: 'JSON',
  //     data: {_token: CSRF_TOKEN, vod_id: vod_id},
  //     success:function(data){
  //       // End of Video logs only every 5 mins to prevent spam
  //       timestamp = moment(Date()).add(5, 'm').toDate();
  //     },
  //     error:function(data) { 
  //       console.log("Error on ajax");
  //       console.log(data.error);
  //       console.log(data);
  //     }
  //   });
  // }
});

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

player.on('play', evt => {    
  // var videoSrc = document.querySelector("#app > main > div.bg-dark > div > div > div.plyr.plyr--full-ui.plyr--video.plyr--html5.plyr--pip-supported.plyr--fullscreen-enabled.plyr--captions-active.plyr--captions-enabled.plyr__poster-enabled.plyr--paused > div.plyr__video-wrapper > video > source")
  // videoSrc.src = 'secret';
})

$(document).ready(function(){
  $(".plyr__volume" ).prop("hidden", 0);
  $(".plyr__control" ).prop("hidden", 0);

  @if (Auth::check())
    player.play();
  @endif
});

$( ".plyr" ).click(function(){
  $( ".plyr__volume" ).prop("hidden", 0);
  $( ".plyr__control" ).prop("hidden", 0);
});
</script>