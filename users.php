<?php
    include 'check.php';
    if ($name !== "Vintage" && $name !== "20deajam" && $name !== "debug") {header("location: index.php");}
    $con = mysqli_connect("localhost", DB_NAME, DB_PASSWORD, DB_TABLE);
    if (isset($_POST['uname'])) {
        $newUname = $_POST['uname'];
        $newPword = $_POST['pword'];
        $newToken = $_POST['token'];
        $type = $_POST['toa'];
        if ($type=="Add") {
            $sql = "INSERT INTO logins (username, password, token) VALUES ('".$newUname."', '".md5($newPword)."', '')";
            $result=mysqli_query($con, $sql);
            if ($result) {
                echo "<script>alert('Added User Successfully!');</script>"; 
                mysqli_close($con);
            }
            else {
                echo "<script>alert('Error Adding User!');</script>";
                mysqli_close($con);
                header("Refresh:0");
            }
        }
        else if ($type =="Update"){
            $update = "UPDATE logins Set ";
            if ($newPword !== '') {
                $update .= "password='".MD5($newPword)."' ";
            }
            $update .= "token='".$newToken."' where username='".$newUname."'";
            $updresult=mysqli_query($con, $update);
            if ($updresult) {
                echo "<script>alert('Updated User Successfully!');</script>"; 
                mysqli_close($con);
            }
            else {
                echo "<script>alert('Error Updating User!');</script>";
                mysqli_close($con);
                header("Refresh:0");
            }
        }
        else {
            $delete = "DELETE from logins where username='".$newUname."'";
            $delresult=mysqli_query($con, $delete);
            if ($delresult) {
                echo "<script>alert('Deleted User Successfully!');</script>"; 
                mysqli_close($con);
            }
            else {
                echo "<script>alert('Error Deleting User!');</script>";
                mysqli_close($con);
                header("Refresh:0");
            }
        }
    }
?>
<html>
    <head>
        <title>Users</title>
        <script src="http://code.jquery.com/jquery-latest.js"></script>
    </head>
    <body>
        <center>
            <h2 style="color: red; margin-top: -20px;">Update Users</h2>
            <form action="users.php" method="POST" style="color: red;">
                <input name="uname" id="uname" placeholder="Enter A Username..."/ ></br>
                <input name="pword" id="pword" type="password" placeholder="Enter A Password..."/></br>
                <input name="token" id="token" placeholder=""/></br>
                <select name="toa">
                    <option value="Add">Add</option>
                    <option value="Update">Update</option>
                    <option value="Delete">Delete</option>
                </select>
                <button type="submit" name="update">Update</button>
            </form>
            <table>
                <tr>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Token</th>
                </tr>
            </table>
        </center>
    </body>
</html>
<?php
    $grab = mysqli_connect("localhost", DB_NAME, DB_PASSWORD, DB_TABLE);
    $grabSql = "SELECT username,password,token FROM logins ORDER BY username";
    $allResult=mysqli_query($grab, $grabSql);

    $all = mysqli_fetch_all($allResult,MYSQLI_ASSOC);
    foreach ($all as $user) {
      $uname = $user['username'];
      $pass = $user['password'];
      $tok = $user['token'];
      echo "<script>$('table').append(\"<tr><td>".$uname."</td><td>".$pass."</td><td>".$tok."</td></tr>\")</script>";
    }
    mysqli_free_result($allResult);
    mysqli_close($grab);
?>
<style>
    body {
        margin: 0;
        margin-top: 25px;
        padding: 0;
        padding-bottom: 15px;
        background-color: black;
    }
    table, th, td {
        border: 3px solid red;
        color: red;
    }
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