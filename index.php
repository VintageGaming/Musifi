<?php
    include 'check.php';
?>
<html>
<head>
	<title><?php echo $name; ?>Musifi</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="update.css"/>
	<script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="main_page.js"></script>
</head>
<body style="background-color: #121212;">
	<div id="searchDiv" class="col-12">
		<img id="Logo" src="VGLogo2.png"/>
		<input type="text" id="searchBox" placeholder="Search" class="col-5"/>
		<button onclick="getVideos();" id="searchButton" class="col-1">Search</button>
	</div>
	<div id="menuLeft" class="col-2">
        <ul class="col-12">
            <li class="col-12 menuLeft-Active">
                <img class="menuLogo" src="//i-love-png.com/images/programs-gt-brochure-the-center-for-global-engagement-80336.png"/>
                <h4>Home</h4>
            </li>
            <li class="col-12" onclick="window.location = '/music';">
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
	<center id="player"></center>
	
	<div id="suggested" class="col-9">
		<ul>

        </ul>
	</div>
	<script>
	    var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api?scrlybrkr";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
	</script>
</body>
</html>