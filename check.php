<?php
	ob_start();
    $con = mysqli_connect("localhost", DB_NAME, DB_PASSWORD, DB_TABLE);
	if (mysqli_connect_errno()) {
		echo 'alert("Failed To Connect");';
		exit();
	}
	if (isset($_COOKIE['check'])) {
        $bite = explode("~", $_COOKIE['check']);
        $name = $bite[0];
        $key = $bite[1];
        $valid = "SELECT * FROM logins WHERE username='$name' and token='$key'";
        $result=mysqli_query($con, $valid);
		if ($result && mysqli_num_rows($result)==1) {
			mysqli_close($con);
            //They're All Good
        } else {
            echo "<script>alert('You're Not ".$name.", or Someone has your Account info.');</script>";
			header('Location: login.php');
			exit();
        }
    }
	else {
		header('Location: login.php');
        exit();
	}
    ob_end_flush();
?>