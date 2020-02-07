<?php
//csatlakozás az adatbázishoz
$con = mysqli_connect("localhost","root","","web");

//adatbázis karakter típusának beállítása utf8-ra (ékezethelyes megjelenítés miatt)
mysqli_set_charset($con, "utf8");

//hiba üzenet kiírása, ha nem tudunk valamiért csatlakozni az adatbázishoz
if (!$con) {
    echo "<script>alert('Hiba az adatbázishoz történő csatlakozás során!'); window.location= 'index.php';</script>";
}
?>