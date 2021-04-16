<?php
    include "../check.php";
?>
<html>
    <head>
        <title><?php echo $name; ?> - Hapara Highlights - Profile</title>
        <link rel="stylesheet" href="styles.css"/>
    </head>
    <body>
        <div id="searchDiv" class="col-12">
		    <img id="Logo" src="../VGLogo2.png"/>
		    <input type="text" id="searchBox" placeholder="Search" class="col-5"/>
		    <button onclick="getVideos();" id="searchButton" class="col-1">Search</button>
	    </div>
        <h2><?php echo $name; ?> - Profile</h2>
        
    </body>
</html>