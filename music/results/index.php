<?php
    include "../../check.php";
?>
<html>
<head>
	<title><?php echo $name; ?> - Hapara Highlights - Active</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="main.css"/>
    <script>
	    var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api?scrlybrkr";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
	</script>
	<script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="../player.js"></script>
    <script src="../main.js"></script>
    <script>
    function search() {
        var what = document.getElementById("searchBox").value;
        window.location = "/music/results/index.php?q=" + what.replace(' ', '+');
    }
</script>
</head>
<body style="background-color: #121212;">
	<div id="searchDiv" class="col-12">
		<img id="Logo" src="../../VGLogo2.png"/>
		<input type="text" id="searchBox" placeholder="Search" class="col-5"/>
		<button onclick="search();" id="searchButton" class="col-1">Search</button>
	</div>
    <div id="menuLeft" class="col-2">
        <ul class="col-12">
            <li class="col-12" onclick="window.location = window.location.origin;">
                <img class="menuLogo" src="//i-love-png.com/images/programs-gt-brochure-the-center-for-global-engagement-80336.png"/>
                <h4>Home</h4>
            </li>
            <li class="col-12 menuLeft-Active" onclick="window.location = '../';">
                <img class="menuLogo" src="//cdn.wccftech.com/wp-content/uploads/2018/01/Youtube-music.png"/>
                <h4>Music</h4>
            </li>
<li class="col-12" onclick="window.location = '/movies';">
                <img class="menuLogo" src="//simpleicon.com/wp-content/uploads/hd-256x256.png"/>
                <h4>Movies</h4>
            </li>
            <li class="col-12" onclick="window.location = '/tv-shows';">
                <img class="menuLogo" src="//cdn3.iconfinder.com/data/icons/computer-and-gadgets-icon-set/50/tv-512.png"/>
                <h4>Tv Shows</h4>
            </li>
        </ul>
    </div>
        <div id="addSong">
            <h3>Add To:</h3>
        </div>
    <div id="results">
        <ul>
        </ul>
    </div>
    <div id="player-bar">
        <img src="//lh3.googleusercontent.com/UviBfK_vIpz85lG9LG3ngodDK8EChXP-wsP6-TSgu83BGIc5WxY29gIJmI4bQsmc2H_a58vbameABLy1=w60-h60-l90-rj"/>
        <h3>Switch Lanes - Rittz</h3>
        <input id="v-slider" type="range" min="1" max="20" value="10"/>
        <button id="player-skip" onclick="skip()"><span></span></button>
        <button id="player-play" onclick="pop()"><span></span></button>
        <button id="player-back" onclick="back()"><span></span></button>
    </div>
    <div id="player">
    
    <div>
</body>
</html>
<script>
    var url = new URL(window.location.href);
    var query = url.searchParams.get("q");
    if (query==null) window.location = "http://musifi.000webhostapp.com/music"
    getVideos(query);
</script>
<?php
    $con = mysqli_connect("localhost", DB_NAME, DB_PASSWORD, DB_TABLE);

    $listsql = "SELECT * from playlists where user='".$name."'";
    $req = mysqli_query($con, $listsql);
    
    if ($req->num_rows > 0) {
        $playlists = mysqli_fetch_all($req, MYSQLI_ASSOC);
        foreach($playlists as $pl) {
            echo "<script>$('#addSong').append('<h4 onclick=\'addSong(\"".$pl['plName']."\")\'>".$pl['plName']."</h4>');</script>";
        }
    }
    echo "<script>$('#addSong').append('<h4 onclick=\'$(\"#addSong\").css(\"visibility\", \"hidden\")\' style=\"color: black;\">Cancel</h4>');</script>";
    echo "<script>user = \"".$name."\";</script>";
?>