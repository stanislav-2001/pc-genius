<?php
    $h1 = "An error happened.";
    $p = "Something happened, it is either your fault, or ours. But most probably your email isn't in our database anymore, nor it has ever been.";
    if(test_input($_GET["mail"]) && test_input($_GET["code"])) {
        $json = json_decode(file_get_contents("emails.json"), true);
        if(array_key_exists($_GET["mail"],$json)) {
            if(!strcmp($_GET["code"], $json[$_GET["mail"]])) {
                unset($json[$_GET["mail"]]);
                file_put_contents("emails.json",json_encode($json));
                $h1 = "You'll be missed!";
                $p = "Your email has been successfully removed from our mailing database. Now you won't get any emails from us anymore. Unless you register for a newsletter again.";
            }
        }
    }
    function test_input(&$input) {
        if(empty($input)) return false;
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return true;
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link href="https://fonts.googleapis.com/css?family=Varela+Round&display=swap" rel="stylesheet">
        <style>
            h1, p {
                color: #2c3e50;
                font-family: 'Varela Round','Public Sans', sans-serif;
            }
            body {
                background-color: #ecf0f1;
            }
            #cont {
                text-align: center;
                margin-top: 200px;
            }
        </style>
    </head>
    <body>
        <div id="cont">
            <h1><?php echo $h1 ?></h1>
            <p><?php echo $p ?></p>
        </div>
    </body>
</html>