<?php
    include '../../check.php';
    $currentPl = $_GET['pl'];
    str_replace("+", " ", $currentPl);
    $plOwner = $_GET['user'];
    $con = mysqli_connect("localhost", DB_NAME, DB_PASSWORD, DB_TABLE);
    $req = "SELECT * from playlists where user='".$plOwner."' AND plName='".$currentPl."'";
    $run = mysqli_query($con, $req);
    $jsSongs = [];
    $songs = mysqli_fetch_assoc($run);
    if ($run->num_rows > 0) {
        array_push($jsSongs, $songs['songs']);
        implode(",", $jsSongs);
    }
    $con->close();
?>
<html>
<head>
	<title><?php echo $name; ?> - Hapara Highlights - Active</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="main.css"/>
	<script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
	    var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api?scrlybrkr";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
	</script>
    <script src="../player.js"></script>
    <script src="../main.js"></script>
    <script>
    function search() {
        var what = document.getElementById("searchBox").value;
        window.location = ("/music/results/index.php?q="+ what.replace(" ", "+"));
    }
</script>
</head>
<body style="background-color: #121212;">
	<div id="searchDiv" class="col-12">
		<img id="Logo" src="../../VGLogo2.png"/>
		<input type="text" id="searchBox" placeholder="Search" class="col-5"/>
		<button onclick="search()" id="searchButton" class="col-1">Search</button>
	</div>
    <div id="menuLeft" class="col-2">
        <ul class="col-12">
            <li class="col-12" onclick="window.location = window.location.origin;">
                <img class="menuLogo" src="//i-love-png.com/images/programs-gt-brochure-the-center-for-global-engagement-80336.png"/>
                <h4>Home</h4>
            </li>
            <li class="col-12 menuLeft-Active" onclick="window.location = window.location.origin + '/music'">
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
        <div id="removeSong">
            <h2 style="color: gray; margin-top: 5px; margin-bottom: 20px; margin-left: 5px; ">Confirm To Delete:</h2>
            <button>Delete</button>
            <button>Cancel</button>
        </div>
    <h1 style="margin-top: 3.5em; margin-left: calc(16.66% + 40px); font-size: 2.5em; color: gray; text-shadow: -1px -1px 0 #514b4b, 1px -1px 0 #514b4b, -1px 1px 0 #514b4b, 1px 1px 0 #514b4b;">
    <?php echo $currentPl; ?></h1>
    <div id="playlistHolder">
        <ul>
        </ul>
    </div>
    <div id="player-bar">
        <img src=""/>
        <h3></h3>
        <input id="v-slider" type="range" min="1" max="20" value="10"/>
        <input id="seek-slider" type="range" min="0" max ="0" value="0"/>
        <button id="player-skip" onclick="skip()"><span></span></button>
        <button id="player-play" onclick="pop()"><span></span></button>
        <button id="player-back" onclick="back()"><span></span></button>
    </div>
    <div id="player">
    
    <div>
</body>
</html>

<?php
    echo "<script>getPl('".implode(",", $jsSongs)."');</script>";
?>