var player;
var volume;
var playing;
var time;

class customArray {
    constructor() { 
        this.car = {};
        this.placement = [];
    }

    get(what) {
        return this.car[playing][what];
    }

    add(vId, title, author, small, medium, large) {
        this.car[vId] = {"title": title, "author": author, "small": small, "medium": medium, "large": large};
        this.placement[this.placement.length] = vId;
    }

    next(vId) {
        if (this.placement[this.placement.indexOf(vId)+1]) {
            return this.placement[this.placement.indexOf(vId)+1];
        }
        else {
            return null;
        }
    }

    back(vId) {
        if (this.placement.indexOf(vId) > 0 && this.placement.length > 1) {
            return this.placement[this.placement.indexOf(vId)-1];
        }
        else {
            return null;
        }
    }

    thumbnail(size) {
        return this.car[playing][size];
    }

    title() {
        return this.car[playing]["title"];
    }

    author() {
        return this.car[playing]["author"];
    }
}

$(document).ready(function() {
    volume = document.getElementById("v-slider");
    let lengthSlider = document.getElementById("seek-slider");
    volume.oninput = function() {
        player.setVolume(this.value*5);
    }
    lengthSlider.oninput = function() {
        player.seekTo(this.value, true);
       
    }
});

function play(id) {
    playing = id;
    if (player == undefined) {
        player = new YT.Player('player', {
            height: '390',
            width: '640',
            videoId: id,
            host: "https://www.youtube-nocookie.com",
            events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
              }
        });
    }
    else {
        player.loadVideoById(id);
    }
    if (time !== undefined) {
        clearInterval(time);
        time = undefined;
    }
    $("#seek-slider").attr("value", "0");
    $("#player-bar h3").html(plm.get("title"));
    $("#player-bar img").attr("src", plm.get("small"));
    $("#player-bar").css("visibility", "visible");
    time = setInterval(function() {
        if(player.getPlayerState() == 1) $("#seek-slider").val(Number(Math.round(player.getCurrentTime())));
    }, 1000);
}

function onPlayerReady(e) {
    e.target.playVideo();
    player.setVolume(volume.value*5);
}

function onPlayerStateChange(e) { 
    if (player.getPlayerState() == 0) {
        time = undefined;
        skip();
    }
    else if (player.getPlayerState() == 1) {
        if (Number($("#seek-slider").attr("max")) == 0) {
            $("#seek-slider").attr("max", player.getDuration());
        }
    }
}

function skip() {
    if (plm.next(playing) == null) return;
    play(plm.next(playing));
}

function pop() {
    if (player.getPlayerState() == 1) {
        player.pauseVideo();
        $("#player-play span").css("background-image", "url('http://musifi.000webhostapp.com/music/imgs/play.png')");
    }
    else if (player.getPlayerState() == 2) {
        player.playVideo();
        $("#player-play span").css("background-image", "url('http://musifi.000webhostapp.com/music/imgs/pause.png')");
    }
}

function back() {
    if (plm.back(playing) == null) return;
    play(plm.back(playing));
}