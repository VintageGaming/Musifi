<?php
    include '../check.php';
    $con = mysqli_connect("localhost", DB_NAME, DB_PASSWORD, DB_TABLE);

    if (isset($_POST['pl-Name'])) {
        $newPlaylist = $_POST['pl-Name'];
        if($newPlaylist =="") return;
        $newPlaylist = mysqli_real_escape_string($con, $newPlaylist);
        $sql = "INSERT INTO playlists (user, plName, songs) VALUES ('".$name."', '".$newPlaylist."', '')";
        $test ="SELECT * from playlists where user='".$name."' AND plName='".$newPlaylist."'";
        $testRes=mysqli_query($con, $test);
        if (mysqli_num_rows($testRes) > 0) {
            //echo "<script>alert('Playlist Already exists.');</script>";
            mysqli_close($con);
            header("Refresh:2");
        }
        else {
        $result=mysqli_query($con, $sql);
        if ($result) {
            //echo "<script>alert('Created Playlist Successfully!');</script>";
            mysqli_close($con);
            header("Refresh:2");
        }
        else {
            //echo "<script>alert('Error Creating Playlist!');</script>";
            mysqli_close($con);
            header("Refresh:0");
        }
        }
    }
?>
<html>
<head>
	<title><?php echo $name; ?> - Hapara Highlights - Active</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="main.css"/>
	<script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="main.js"></script>
    <script>
    function search() {
        var what = document.getElementById("searchBox").value;
        window.location = ("/music/results/index.php?q="+ what.replace(" ", "+"));
    }
</script>
</head>
<body style="background-color: #121212;">
	<div id="searchDiv" class="col-12">
		<img id="Logo" src="../VGLogo2.png"/>
		<input type="text" id="searchBox" placeholder="Search" class="col-5"/>
		<button onclick="search()" id="searchButton" class="col-1">Search</button>
	</div>
    <div id="menuLeft" class="col-2">
        <ul class="col-12">
            <li class="col-12" onclick="window.location = window.location.origin;">
                <img class="menuLogo" src="//i-love-png.com/images/programs-gt-brochure-the-center-for-global-engagement-80336.png"/>
                <h4>Home</h4>
            </li>
            <li class="col-12 menuLeft-Active">
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
        <div id="createPlaylistForm">
            <h2 style="color: gray; margin-top: 5px; margin-bottom: 20px; margin-left: 5px; ">Create a Playlist:</h2>
            <form action="index.php" method="POST">
            <input id="pl-Name" name="pl-Name" placeholder="Playlist Name..."/>
            <button type="button" onclick="$('#createPlaylistForm').css('visibility', 'hidden');">Cancel</button>
            <button type="submit">Create</button>
            </form>
        </div>
    <h1 style="margin-left: calc(16.66% + 40px); font-size: 2.5em; color: gray; text-shadow: -1px -1px 0 #514b4b, 1px -1px 0 #514b4b, -1px 1px 0 #514b4b, 1px 1px 0 #514b4b;">Your Library:</h1>
    <div id="playlistHolder">
        <ul>
            <li onclick="$('#createPlaylistForm').css('visibility', 'visible');">
                <div id="playlist-add">
                    <img src="//cdn3.iconfinder.com/data/icons/buttons/512/Icon_11-512.png" style="width: 75px; height: 75px; margin: 25%;"/>
                </div>
            </li>
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

<?php
    echo "<script>user='".$name."';</script>";
    $getPls = "SELECT * from playlists where user='".$name."'";
    $plResult=mysqli_query($con, $getPls);
    if ($plResult->num_rows > 0) {
        $playlists = mysqli_fetch_all($plResult, MYSQLI_ASSOC);
        foreach($playlists as $pl) {
            echo "<script>$('#playlistHolder ul').append('<li onclick=\"playlist(\'".$pl['plName']."\');\"><div><img src=\'//cdn0.iconfinder.com/data/icons/mixed-18/65/29-512.png\' style=\'width: 75px; height: 75px; margin: 25%;\' /><h2>".$pl['plName']."</h2></div></li>');</script>";
        }
    }
    $conn->close();

?>