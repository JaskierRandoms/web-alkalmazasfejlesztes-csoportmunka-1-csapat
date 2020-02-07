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
    <title>Regisztráció</title>
</head>
<body>
    <div class = "UI">
        <div class = "dummy">
            <form action="" method="POST">
            <label for="username">Felhasználónév:</label>
            <input class="textbox" type="text" name="username" id="username" placeholder = "kispista" autocomplete="off" value="<?php if(isset($_SESSION["username"])) { echo $_SESSION["username"]; } ?>" required><br><br>
            <label for="password">Jelszó:</label>
            <input class="textbox" type="password" name="password" id="password" autocomplete="off" required><br><br>
            <label for="repassword">Jelszó újra:</label>
 		    <input class="textbox" type="password" name="repassword" id="repassword" autocomplete="off" required><br><br>
            <input type="submit" name="register" value="Regisztráció">
            </form>
            <form action="index.php">
                <input id="login" type="submit" name="login" value="Bejelentkezés">
            </form>
        </div>
    </div>
    <?php
    if (isset($_POST['register'])) {
        require_once 'dbcon.php';
        $username = $_POST['username'];
        $query = mysqli_query($con, "SELECT * FROM users WHERE user LIKE '$username'");
        if (mysqli_num_rows($query) == 0) {
            if (isset($_SESSION['username'])) {
                unset($_SESSION['username']);
            }
            $password = $_POST['password'];
            $repassword = $_POST['repassword'];
            if (strcmp($password,$repassword) == 0) {
                $passwordhash = password_hash($password,PASSWORD_DEFAULT);
                mysqli_query($con, "INSERT INTO users (user, password, admin) VALUES ('$username','$passwordhash','0')");    
                echo "<script>alert('Sikeres regisztráció!'); window.location= 'index.php';</script>";
            }
            else {
                echo "<script>alert('A két jelszó, nem eggyezik!'); window.location= 'register.php';</script>";
                $_SESSION['username'] = $username;
            }
        }
        else {
            echo "<script>alert('A megadott felhasználónév, már folglalt!'); window.location= 'register.php';</script>";
            $_SESSION['username'] = $username;
        }
    }
    ?>
</body>
</html>