<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: index.php");
}
require_once 'dbcon.php';
if (isset($_POST['change'])) {
    $userid = $_POST['userid']; 
    $admin = $_POST['admin']; 
    $change = !$admin;
    mysqli_query($con, "UPDATE users SET admin='$change' WHERE id='$userid'");
    header("refresh: 0");
}
if (isset($_POST['delete'])) {
    $userid = $_POST['userid']; 
    mysqli_query($con, "DELETE FROM messages WHERE userid='$userid'");
    mysqli_query($con, "DELETE FROM users WHERE id='$userid'");
    header("refresh: 0");
}
$userid = $_SESSION['userid'];
$qcmd = "SELECT id, user, admin FROM users WHERE id<>'$userid' ORDER BY admin DESC";
$query = mysqli_query($con, $qcmd);
$str="";
$array = array();

if ($_SESSION['admin']) {
    while($row = mysqli_fetch_assoc($query)) {
        $str.="<span id='user'>".$row['user']."</span>";
        $str.="<span id='functions'>".
        "<form id='functions' action='' method='POST'>
        <input id='del' type='submit' name='delete' value=''>
        <input type='hidden' value='".$row['id']."' name='userid'>
        </form>".
        "<form id='changebtn' action='' method='POST'>
        <input  type='submit' name='change' value=";
        if ($row['admin']){ 
            $str.='Admin';
        }
        else {
            $str.='Felhasználó';
        }
        $str.=">
        <input type='hidden' value='".$row['id']."' name='userid'>
        <input type='hidden' value='".$row['admin']."' name='admin'>
        </form>"
        ."</span>";
        array_push($array,$str);
        $str="";
    }
}
else {
    while($row = mysqli_fetch_assoc($query)) {
        $str.="<span id='user'>".$row['user']."</span>";
        array_push($array,$str);
        $str="";
    }
}
echo "</from>";
	
function kiir($elem){
    if($_SESSION['admin']){
        echo "<div  class = 'admin'>";
    }
    else{
        echo "<div class = 'user'>";
    }
    echo $elem;
    echo "</div>";
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css" type = "text/css">
    <title>Felhasználók</title>
</head>
<body>
    <div class="UI2">
        <div id="center2">
            <div id="members">
                <?php
                for($i = 0; $i < sizeof($array); $i++){
                    kiir($array[$i]);
                    echo "<br><hr>";
                }
                ?>
            </div>
            <div id = "back">
                <form action="UI.php">
                    <input type="submit" name="back" value="Vissza">
                </form>
            </div>

        </div>
    </div>
</body>
</html>
<?php
?>