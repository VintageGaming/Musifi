var url = new URL(window.location.href);
var watch = url.searchParams.get("v");
var pId = url.searchParams.get("list");
var loop = url.searchParams.get("loop") ? url.searchParams.get("loop") : "off";
if (loop == 0)
	$("#loopImg").attr("src","loop-checked.png");
else if (loop == 1)
	$("#loopImg").attr("src","loop-song.png");
var player;
var playlistItems = [];

//Json Querys ---- Getting the info

function getPopular() {
	let where = 'https://www.googleapis.com/youtube/v3/search?part=snippet&chart=mostPopular&maxResults=10&key=API_KEY';
	try {
        fetch(where)
    .then(res => res.json())
    .then((out) => {
      vid = out;
      $.each(vid.items, function(index, item) {
            displayPopular(item);
      });
    })
    .catch(err => { throw err });
    }
    catch (e) {
        alert("Recommended Load Error: " + e);
    }
}

function getVideos() {
	
	if ($("#player").length) $("#player").remove();
	if ($("#playlistContainer").length) $("#playlistContainer").remove();
	
	let q = document.getElementById('searchBox').value;
	let where = 'https://www.googleapis.com/youtube/v3/search?part=snippet&q=' + q + '&maxResults=15&key=API_KEY';
	try {
        fetch(where)
    .then(res => res.json())
    .then((out) => {
      vid = out;
	  if (!$("#suggested").length) $("body").append('<div id="suggested" class="col-9"><ul></ul></div>');
	  else $("#suggested ul").empty();
      $.each(vid.items, function(index, item) {
            displaySearch(item);
      });
    })
    .catch(err => { throw err });
    }
    catch (e) {
        alert("Video Search Error: " + e);
    }
}

function loadPlaylist() {
	let where = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId="+pId+"&maxResults=50&key=API_KEY";
    try {
        fetch(where)
    .then(res => res.json())
    .then((out) => {
      let vid = out;
	  $('body').append('<div id="playlistContainer"><div id="playlistControls"><center><img id="loopImg" onclick="loopS();" src="loop-unchecked.png"/></center></div><div id="pVidContainer"></div></div>');
      for (let i=0;i<vid.items.length;i++) {
          playlistItems.push(vid.items[i].snippet.resourceId.videoId);
          $('#pVidContainer').append('<div id="playlistItem" onclick="play(\''+vid.items[i].snippet.resourceId.videoId+'\');"><h2 onclick="play(\''+vid.items[i].snippet.resourceId.videoId+'\');">' + vid.items[i].snippet.title + '</h2></div>');
      }
	  if (!watch){
	    watch = playlistItems[0];
        play(watch);
      }
    })
    .catch(err => { alert("Playlist Load Error: "+err); });
    }
    catch (e) {
        alert(e);
    }
}

//Display Results and Video Loading
//ADDED CLASSES
function displayPopular(what) {
	let thumbnail = what.snippet.thumbnails.high.url;
	let title = what.snippet.title;
	let videoId = what.id.videoId;
	let publisher = what.snippet.channelTitle;
	$('#suggested ul').append('<li><div id="result" class="col-12"><img class="thumbnail" src="' + thumbnail + '" onclick="play(\'' + videoId + '\')\" /><h2 class="vidTitle" onclick="play(\'' + videoId + '\')\">' + title + '</h2><h3>'+publisher+'</h3></div></li>');
}

function displaySearch(what) {
	let thumbnail = what.snippet.thumbnails.high.url;
	let title = what.snippet.title;
	let publisher = what.snippet.channelTitle;
	var videoId;
	pId = false;
	if (what.id.kind == "youtube#video") videoId = 'play(\''+what.id.videoId+'\')';

	else if (what.id.kind == "youtube#channel") { videoId = 'channel(\''+what.id.channelId+'\')'; }

    else if (what.id.kind == "youtube#video") videoId = 'play(\''+what.id.videoId+'\')';

    else if (what.id.kind == "youtube#playlist") { videoId = 'playlist(\''+what.id.playlistId+'\')'; title = "(Playlist) " + title; }

    $('#suggested ul').append('<li><div id="result" class="col-12"><img class="thumbnail" src="' + thumbnail + '" onclick="'+videoId+'" /> <h2 class="vidTitle" onclick="' + videoId + '">' + title + '</h2><h3>'+publisher+'</h3></div></li>');
}

function displayChanVideos(what) {
	let thumbnail = what.snippet.thumbnails.high.url;
	let title = what.snippet.title;
	let videoId = what.id.videoId;
	let publisher = what.snippet.channelTitle;
	$('#suggested ul').append('<li><div id="result" class="col-12"><img class="thumbnail" src="' + thumbnail + '" onclick="play(\'' + videoId + '\')\" /><h2 class="vidTitle" onclick="play(\'' + videoId + '\')\">' + title + '</h2><h3>'+publisher+'</h3></div></li>');
}

function play(vidId) {
	if (pId) vidId = vidId + "&list=" + pId;
	if (loop != "off") vidId = vidId + "&loop=" + loop;
	window.location = "//ytbypass.000webhostapp.com/index.php?v=" + vidId;
}

function playVideo(vId) {
	if ($("#results").length) $("#results").remove();
	if ($("#suggested").length) $("#suggested").remove();
	player = new YT.Player('player', {
          height: '511',
          width: '854',
          videoId: vId,
		  host: "https://www.youtube-nocookie.com",
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        });
		$("#player").css("visibility", "visible");
	//$("body").append('<center><iframe id="video" width="854px" height="511px" src="http://www.youtube-nocookie.com/embed/' + vId + '?rel=0" vid="" allowfullscreen=""></iframe></center>');
}
//Youtube Player Api functions here
function onYouTubeIframeAPIReady() {
	if (!watch && !pId) {
		getPopular();		
	}
	else if (watch){
		playVideo(watch);
		if(pId) loadPlaylist();
	}
	else {
		loadPlaylist();
        $("#player").css("visibility", "visible");
        $("#player").css("height", "511");
        $("#player").css("width", "854");
	}
}

function onPlayerReady() {
	player.playVideo();
}
//End of YT Player Api Functions
function onPlayerStateChange(e) {
	if (player.getPlayerState() == 0) {
		if (loop == 0) {
        let nvid = playlistItems.indexOf(urlId) + 1;
        window.location = "//ytbypass.000webhostapp.com/index.php?v="+playlistItems[nvid]+"&list="+playlistId+"&loop=0";
        }
        else if (loop == 1) {
            player.seekTo(0);
        }
	}
}

function channel(channel) {
	var url = 'https://www.googleapis.com/youtube/v3/search?part=snippet&channelId='+channel+'&type=video&order=date&maxResults=10&key=API_KEY';
    try {
        fetch(url)
    .then(res => res.json())
    .then((out) => {
      vid = out;
		$("#suggested ul").empty();
      $.each(vid.items, function(index, item) {
            displayChanVideos(item);
      });
    })
    .catch(err => { throw err });
    }
    catch (e) {
        alert("Channel Load Error: " + e);
    }
}

function playlist(pl) {
    let isLoop = " ";
    if (loop != "off") isLoop = "&loop=" + loop;
	window.location = "//ytbypass.000webhostapp.com/index.php?list=" + pl + isLoop;
}

//loop song -----------

function loopS() {
	if (loop == "off"){
		loop = 0;
		$("#loopImg").attr("src","loop-checked.png");
	}
	else if (loop == 0) {
		loop = 1;
		$("#loopImg").attr("src","loop-song.png");
	}
	else {
		loop = "off";
		$("#loopImg").attr("src","loop-unchecked.png");
	}
}
//--------------------------------------------------------------------
//--------------------------------------------------------------------


$( document ).ready(function() {
    var input = document.getElementById("searchBox");

	// Execute a function when the user releases a key on the keyboard
	input.addEventListener("keyup", function(event) {
		// Number 13 is the "Enter" key on the keyboard
		if (event.keyCode === 13) {
			// Cancel the default action, if needed
			event.preventDefault();
			// Trigger the button element with a click
			document.getElementById("searchButton").click();
		}
	});
    var adbp = document.getElementsByTagName('div');
    adbp[adbp.length-1].outerHTML = "";
});