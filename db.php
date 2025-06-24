<?php 
    define("servername","localhost");
    define("dbport",3306);
    define("username","root");
    define("password","RootPassword");
    define("dbname","databaza");

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
    $conn = new mysqli(servername, username, password, dbname, dbport);
    mysqli_set_charset($conn,"utf8mb4");
?>