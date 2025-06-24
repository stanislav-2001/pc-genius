<?php 
    //$_COOKIE[$_SERVER["REMOTE_ADDR"]] = "set";
    echo setcookie("gdpr", "set", time() + (86400 * 30), "/");
?>