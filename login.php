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
            header('Location: index.php');
            exit();
        } else {
			echo "<script>alert('You have an old token! Click the i in the circle to the left of the URL, Click cookies, Click hhsgames.000webhostapp.com, and Click Remove.');</script>";
        }
    }
    else if(isset($_POST['uname'])) {
        $uname = $_POST['uname'];
        $pword = $_POST['pword'];

        $uname = stripslashes($uname);
        $pword = stripslashes($pword);

        $uname = mysqli_real_escape_string($con, $uname);
        $pword = mysqli_real_escape_string($con, $pword);
        $login = "SELECT * FROM logins WHERE username='$uname' and password='".md5($pword)."'";
        $result=mysqli_query($con, $login);

        if ($result && mysqli_num_rows($result)==1) {
			$austin = $result->fetch_assoc();
			if ($austin['token']!=="") {echo "<script>alert('You\'re Not ".$uname.", or Someone has your Account info.\\n Disclaimer:\\n You May only Login on one Computer. If you have accidentally used your account on a computer that is not yours, send a login request with your username and put in the password field as stated: \"Token Reset\". ');</script>"; header("Location: login.php");}
			else {
				$token = uniqid(rand(), true);
				$ins_token = "UPDATE logins SET token='$token' WHERE username='$uname'";
			    mysqli_query($con, $ins_token);
                setcookie('check', $uname."~".$token, time()+60*60*24*30*8, "/");
				header('Location: index.php');
				exit();
			}
        } else {
            echo "<script>alert('Incorrect!');</script>";
        }
    }
    else {
        //Not A Login Attempt
    }
    ob_end_flush();
?>
<html>
    <head>
        <title>Hapara Highlights - Login</title>
    </head>
    <body style="background-color: black;">
	<center>
    <img src="//assets.stickpng.com/thumbs/580b57fcd9996e24bc43c545.png" width="300px" height="250px"/>
        <h2 style="color: red; margin-top: -20px;">One-Time Login</h2>
        <form action="login.php" method="POST" style="color: red;">
            <input name="uname" id="uname" placeholder="Enter Your Username..."/ ></br>
            <input name="pword" id="pword" type="password" placeholder="Enter Your Password..."/></br>
            <button type="submit">Login</button></br>
            <h5><a href="request.php">Request Login</a></h5>
        </form>
	</center>
    <style>
        h2 {
            font-family: sans-serif;
        }

        input {
            border: 2px solid red;
            margin-bottom: 5px;
            border-radius: 2px;
            width: 200px;
            height: 25px;
            background-color: black;
            color: red;
            font-family: sans-serif;
        }

        button {
            background-color: black;
            border: 2px solid red;
            border-radius: 2px;
            color: red; 
            width: 75px;
            height: 30px;
        }
    </style>
    </body>
</html>