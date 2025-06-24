<?php
    $email = test_input($_POST['email']);
    if(filter_var($email,FILTER_VALIDATE_EMAIL)) { 
        if(!file_exists("emails.json")) file_put_contents("emails.json", "[]");
        $data = file_get_contents("emails.json");
        $emaily = json_decode($data, true);
        if(!array_key_exists($email, $emaily)) {
            $hash = sha1($email . (string)microtime());
            $emaily[$email] = $hash;
            file_put_contents("emails.json",json_encode($emaily));
            echo "OK";
        } else echo "AL";
    }
    else {
        echo "WF";
    }
    function test_input($input) {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }
?>
