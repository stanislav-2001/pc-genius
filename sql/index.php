<?php
$servername = "localhost";
$username = "root";
$password = "password";

// Create connection
$conn = new mysqli($servername, $username, "", "databaza"); /* TODO: doplnit meno databazy a HESLO! */

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";

function first_time() {
    $sql1 = <<<EOD
    CREATE TABLE MyGuests (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        firstname VARCHAR(30) NOT NULL,
        lastname VARCHAR(30) NOT NULL,
        email VARCHAR(50),
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )
EOD;
}

function mechanizmus($oldstr) {
    $oldstr = strtolower($oldstr);
    $newstr = "";
    for($i = 0; $i < strlen($oldstr); $i++) {
        $char = substr($oldstr, $i, 1);
        if(ord($char) >= 97 && ord($char) <= 122) {
            $newstr .= $char;
        }
        else if(ord($char) === 32) {
            $newstr .= "-";
        }
    }
    return $newstr;
}
//a-z : 97-122
//'-' : 45
//' ' : 32
?>