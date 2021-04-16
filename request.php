<?php
    if ($_POST['uname']) {
    try {
        $name = $_POST['name'];
        $uname = $_POST['uname'];
        $pword = $_POST['pword'];
        $info = "Name: ".$name."\nUsername: ".$uname."\nPassword: ".$pword;
        $headers = "From: requests@hhsgames.000webhostapp.com" . "\r\n" . "CC: somebodyelse@example.com";
        $send = mail("20deajam@hayward.k12.wi.us", " YT Login Request", $info, $headers);
    }
    catch (Exception $e) {
        echo '<script>alert("Error in Request!");</script>';
    }
    }
?>
<html>
    <head>
        <title>Hapara Highlights - Active - Request</title>
    </head>
    <body>
	<center>
        <img src="//assets.stickpng.com/thumbs/580b57fcd9996e24bc43c545.png" width="300px" height="250px"/>
        <h2>Request Login</h2>
        <form action="request.php" method="POST">
            <input name="name" id="name" placeholder="What's Your Name?" required="required" maxlength="13"/></br>
            <input name="uname" id="uname" placeholder="Enter A Username..." required="required" maxlength="13"/></br>
            <input name="pword" id="pword" type="password" placeholder="Enter A Password..." required="required" maxlength="13"/></br>
            <button type="submit">Login</button></br>
            <h5><a href="login.php">Login Page</a></h5>
        </form>
	</center>
    <style>
        body {
            background-color: black;
        }
        h2, h5 {
            color: red;
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