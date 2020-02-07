<?php
session_start();
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css" type = "text/css">
    <title>Bejelentkezés</title>
</head>
<body>
    <div class = "UI">
        <div class = "dummy">
            <form action="" method="POST">
            <label for="username">Felhasználónév:</label>
            <input class="textbox" type="text" name="username" id="username" placeholder="kispista" autocomplete="off" value="<?php if(isset($_SESSION["username"])) { echo $_SESSION["username"]; } ?>" required><br><br>
            <label for="password">Jelszó:</label>
            <input class="textbox" type="password" name="password" id="password"autocomplete="off" required><br><br>
            <input type="submit" name="login" value="Bejelentkezés">
            </form>
            <form action="register.php">
                <input id="register" type="submit" name="register" value="Regisztráció">
            </form>
        </div>
    </div>
    <?php
    if (isset($_POST['login'])) {
        require_once 'dbcon.php';
        $username = $_POST['username'];
        $password = $_POST['password'];
        $query = mysqli_query($con, "SELECT id, password, admin FROM users WHERE user LIKE '$username'");
        if (mysqli_num_rows($query) > 0) {
            while($row = mysqli_fetch_assoc($query)) {
                if (password_verify($password,  $row['password'])) {
                    unset($_SESSION['username']);
                    $_SESSION['admin'] = $row['admin'];
                    $_SESSION['userid'] = $row['id'];
                    header("Location: UI.php");
                }
                else {
                    $_SESSION['username'] = $username;
                    echo "<script>alert('Hibás felhasználónév, vagy jelszó!');window.location='index.php';</script>";
                }
            }
        }
        else {
            $_SESSION['username'] = $username;
            echo "<script>alert('Hibás felhasználónév, vagy jelszó!');window.location='index.php';</script>";
        }
        
    }
    ?>
</body>
</html>