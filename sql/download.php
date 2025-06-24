<?php
 //Stiahnutie celej databázy do JSON súboru
    if(!isset($_GET["pass"]) || $_GET["pass"] !== sha1("adminheslo2025!")) {
        echo "No permission.";
        die();
    }
    //include 'db.php';
    $dbs = array("clanky", "kategorie", "tagy", "related");
    $fular = array();
    foreach($dbs as $db) {
        $sql = "SELECT * FROM $db";
        $q = mysqli_query($conn, $sql);
        $rows = array();
        while($row = mysqli_fetch_assoc($q)) {
            $rows[] = $row;
        }
        $fular[] = $rows;
    }
    $str = htmlspecialchars(json_encode($fular));
    echo $str;
    mail("spamystanko4@gmail.com", "Zaloha", $str, "From: newsletter@pcgenius.xyz");
    echo "OK";
?>