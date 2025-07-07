<?php
function connect_db() {
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db = 'employees';

    $conn = mysqli_connect($host, $user, $pass, $db);
    if (!$conn) {
        die("Erreur connexion DB : " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    
    return $conn;
}
