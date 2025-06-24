<?php 
    $nadpis = "Skúšobný článok 3";
    $fotka = "https://dsc.invia.sk/img/web-830/2017/10/31/m0/495661.jpg";
    $fname = "https://google.com";
    include 'sendmails.php';
    echo "SKUSKA";
    send_mails($nadpis, $fotka, $fname);
    echo "OKEJ";
?>