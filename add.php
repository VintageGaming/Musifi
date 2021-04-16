<?php
    include 'check.php';
    if ($name !== "Vintage" || $name !== "20deajam") {header("location: index.php");}
    $con = mysqli_connect("localhost", DB_NAME, DB_PASSWORD, DB_TABLE);
    if ($_POST['uname']) {
        $adduname = $_POST['uname'];
        $addpword = $_POST['pword'];
        $sql = "INSERT INTO logins (username, password, token) VALUES ('".$adduname."', '".md5($addpword)."', '')";
        $result=mysqli_query($con, $sql);
        if ($result) {
            echo "<script>alert('Added User Successfully!');</script>"; 
            mysqli_close($con);
            header("location: index.php");
        }
        else {
            echo "<script>alert('Error Adding User!');</script>";
            mysqli_close($con);
            header("Refresh:0");
        }
    }
?>
<html>
    <head>
        <title>Add User - Hapara Highlights - Active</title>
    </head>
    <body style="background-color: black;">
	<center>
    <img src="//assets.stickpng.com/thumbs/580b57fcd9996e24bc43c545.png" width="300px" height="250px"/>
        <h2 style="color: red; margin-top: -20px;">Add User</h2>
        <form action="add.php" method="POST" style="color: red;">
            <input name="uname" id="uname" placeholder="Enter Your Username..."/ ></br>
            <input name="pword" id="pword" type="password" placeholder="Enter Your Password..."/></br>
            <button type="submit" name="submit">Add</button>
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