var user;
var selection;
var songs = [];
var searcharr = [];
var plm = new customArray();

function getVideos(q) {
	
	let where = 'https://www.googleapis.com/youtube/v3/search?part=snippet&q=' + q + '&type=video&videoCategoryId=10&maxResults=15&key=API_KEY';
	try {
        fetch(where)
    .then(res => res.json())
    .then((out) => {
      vid = out;
      saveSearch(vid);
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

function displaySearch(song) {
    let thumbnail = song.snippet.thumbnails.high.url;
	let title = song.snippet.title;
	let publisher = song.snippet.channelTitle;
    $("#results ul").append("<li><div onclick='play(\""+song.id.videoId+"\")'><img src='"+thumbnail+"'/><h2>"+title+"</h2><h4>"+publisher+"</h4></div><img class='options' src='//www.materialui.co/materialIcons/navigation/more_vert_grey_192x192.png' onclick='show(\""+ song.id.videoId +"\")'/></li>");
}

function show(vid) {
    selection = vid;
    $("#addSong").css("visibility", "visible");
}

function addSong(pl) {
    $.ajax({
      type: "POST",
      url:'http://musifi.000webhostapp.com/music/addSong.php',
      data: {'id': selection, 'user': user, 'pl': pl},
      complete: function (response) {
          //ehh
      },
      error: function () {
          //ehh
      }
  });
  $("#addSong").css("visibility", "hidden");
  return false;
}

function playlist(pl) {
    window.location = "/music/playlist/index.php?user="+user+"&pl="+pl;
}

function getPl(songs) {
    let where = 'https://www.googleapis.com/youtube/v3/videos?part=snippet&id=' + songs + '&key=API_KEY';
	try {
        fetch(where)
    .then(res => res.json())
    .then((out) => {
      vid = out;
      save(vid);
      displayPl();
    })
    .catch(err => { throw err });
    }
    catch (e) {
        alert("Video Search Error: " + e);
    }
}

function displayPl() {
    for (var song in songs) {
        $("#playlistHolder ul").append("<li onclick='play(\""+songs[song]["id"]+"\")'><div class='song'><img src='"+songs[song]["thumbnail-small"]+"'/><h3>"+songs[song]["title"]+"</h3><h4>"+songs[song]["author"]+"</h4></div></li>");
    }
}

function save(videos) {
    $.each(videos.items, function(index, video) {
        plm.add(video.id, video.snippet.localized.title, video.snippet.channelTitle, video.snippet.thumbnails.default.url, video.snippet.thumbnails.medium.url, video.snippet.thumbnails.high.url);
        songs[video.id] = {"title": video.snippet.localized.title, "author": video.snippet.channelTitle, "id": video.id, "thumbnail-small": video.snippet.thumbnails.default.url, "thumbnail-medium": video.snippet.thumbnails.medium.url, "thumbnail-high": video.snippet.thumbnails.high.url};
    });
}

function saveSearch(videos) {
    $.each(videos.items, function(index, video) {
        plm.add(video.id.videoId, video.snippet.title, video.snippet.channelTitle, video.snippet.thumbnails.default.url, video.snippet.thumbnails.medium.url, video.snippet.thumbnails.high.url);
        searcharr[video.id.videoId] = {"title": video.snippet.title, "author": video.snippet.channelTitle, "id": video.id.videoId, "thumbnail-small": video.snippet.thumbnails.default.url, "thumbnail-medium": video.snippet.thumbnails.medium.url, "thumbnail-high": video.snippet.thumbnails.high.url};
    });
}

$(document).ready(function() {
    $("body div:last").remove();
});