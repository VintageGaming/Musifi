<?php
    $con = mysqli_connect("localhost", DB_NAME, DB_PASSWORD, DB_TABLE);

    if (isset($_POST['id'])) {
        $song = $_POST['id'];
        $user = $_POST['user'];
        $playlist = $_POST['pl'];
        if($song =="") return;
        $pl = "SELECT from playlists where user='".$user."' AND plName = '".$playlist."'";
        $getpl = mysqli_query($con, $pl);
        $reqsongs = mysqli_fetch_assoc($getpl)['songs'] .$song.",";
        $sql = "UPDATE playlists set songs=concat(songs, '".$reqsongs."') where user='".$user."' AND plName='".$playlist."'";
        $add=mysqli_query($con, $sql);
        echo "Success!";
    }
    else echo "Failed!";
?>