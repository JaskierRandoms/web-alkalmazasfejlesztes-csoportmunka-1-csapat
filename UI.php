<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: index.php");
}
if (isset($_POST['send'])) {
    require_once 'dbcon.php';
    $userid = $_SESSION['userid'];
    $message = $_POST['msg'];
    mysqli_query($con, "INSERT INTO messages (userid, message, date) VALUES ('$userid','$message',CURRENT_TIME)");
    header("refresh: 0");
}
if (isset($_POST['delete'])) {
    require_once 'dbcon.php';
    $userid = $_POST['userid'];
    $date = $_POST['date'];
    mysqli_query($con, "DELETE FROM messages WHERE userid='$userid' AND date='$date'");                 
    header("refresh: 0");
}
require_once 'dbcon.php';
$qcmd = "SELECT userid, user, message, date FROM messages INNER JOIN users ON users.id=messages.userid ORDER BY date desc";
$query = mysqli_query($con, $qcmd);
$str="";
$array = array();

if ($_SESSION['admin']) {
    while($row = mysqli_fetch_assoc($query)) {
        $str .= "<div id = 'divmsg'>";
        $str.="<span id='user'>".$row['user'].": "."</span>";
        $str .= $row['message'];
        $str .= "</div>";

        $str .= "<div id = 'divdate'>";
        $str .= $row['date'].
        "<form id='date' action='' method='POST'>
        <input id='del' type='submit' name='delete' value=''>
        <input type='hidden' value='".$row['userid']."' name='userid'>
        <input type='hidden' value='".$row['date']."' name='date'>
        </form>";
        $str .= "</div>";
        array_push($array,$str);
        $str="";
    }
}
else {
    while($row = mysqli_fetch_assoc($query)) {
        $str .= "<div id = 'divmsg'>";
        $str.="<span id='user'>".$row['user'].": "."</span>";
        $str .= $row['message'];
        $str .= "</div>";
        
        $str .= "<div id = 'divdate2'>";
        $str .= $row['date'];
        $str .= "</div>";
        array_push($array,$str);
        $str="";

    }
}
echo "</from>";
	
function kiir($elem){
/*     echo "<hr>";
 */    echo $elem;
}

?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css" type = "text/css">
    <title>Üzenetek</title>
</head>
<body>
    <div class="UI2">
        <div id="left">
            <form action="members.php" method="post">
                <input type="submit" name="members" value="Felhasználók">
                <label id="txt" for="msg">Üzenet:</label>
            </form>
        </div>
        <div id="center">
            <div id="messages">
                <?php
                for($i = 0; $i < sizeof($array); $i++){
                    echo "<div id = 'message'>";
                    kiir($array[$i]);                    
                    echo "</div>";
                    echo "<hr>";
                }
                ?>
            </div>
            <div id="date">
            </div>
            <textarea name="msg" id="msg" rows="5" cols="80" placeholder="Ide írhatod, az üzenetedet!" form="sendmsg"></textarea>
        </div>
        <div id="right">
            <form action="logout.php" method="post">
                <input  type="submit" name="logout" value="Kijelentkezés">
            </form>
            <form id="sendmsg" action="" method="post">
                <input id="send" type="submit" name="send" value="Küldés">
            </form>
        </div>
    </div>
</body>
</html>
<?php

?>