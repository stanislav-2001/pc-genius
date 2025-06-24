<?php 
//setup:
/* CREATE TABLE `databaza`.`clanky` ( `clanok_id` INT NOT NULL AUTO_INCREMENT , `nazov` VARCHAR(255) NOT NULL , `html_obsah` TEXT NOT NULL , `url` VARCHAR(255) NOT NULL , `obr_semiurl` VARCHAR(255) NOT NULL , `kategoria` INT NOT NULL , PRIMARY KEY (`clanok_id`)) ENGINE = MyISAM COMMENT = 'Tagy su v druhej tabulke';*/
/* CREATE TABLE `databaza`.`tagy` ( `clanok_id` INT NOT NULL , `tag` VARCHAR(255) NOT NULL ) ENGINE = MyISAM; */
/* CREATE TABLE `databaza`.`related` ( `povodny_clanok_id` INT NOT NULL , `sug_clanok_id` INT NOT NULL , `zhody` INT NOT NULL ) ENGINE = MyISAM; */
/* ALTER DATABASE databaza CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ 

/*SELECT tag, COUNT(*) from tagy GROUP BY tag HAVING COUNT(*)=2 */ //pocet zhod

//pridat clanok

define("servername","localhost");
define("username","root");
define("password","password");
define("dbname","databaza");

$conn = new mysqli($servername, $username, "", "databaza");

define("CLANKOV_NA_STRANU",10);

function clanok($nazov, $html_obsah, $url, $obr_semiurl, $kategoria, $tagy) { //assuming že $tagy = distinct array
    $con = $GLOBALS['conn'];
    $nazov = mysqli_real_escape_string($con, $nazov);
    $html_obsah = mysqli_real_escape_string($con, $html_obsah);
    $url = mysqli_real_escape_string($con, $url);
    $obr_semiurl = mysqli_real_escape_string($con, $obr_semiurl);
    $sql = "INSERT INTO clanky (nazov, html_obsah, url, obr_semiurl, kategoria)
    VALUES ('$nazov', '$html_obsah', '$url', '$obr_semiurl', '$kategoria')";

    if (mysqli_query($con, $sql)) {
        $last_id = mysqli_insert_id($con);
        echo "New record created successfully. Last inserted ID is: " . $last_id;
        if(count($tagy) > 0) {
            $nsql = "INSERT INTO tagy (clanok_id, tag)
            VALUES ";
            foreach($tagy as $tag) {
                $tag = mysqli_real_escape_string($con, $tag);
                $nsql .= "('$last_id', '$tag'),";
            }
            $nsql = substr($nsql, 0, -1);
            mysqli_query($con, $nsql);

            //komparacia:
            for($index = 1; $index < $last_id; $index++) {
                $sql = "SELECT tag, COUNT(*) FROM `tagy` WHERE (clanok_id='$index' OR clanok_id='$last_id') GROUP BY tag HAVING COUNT(*)=2";
                $result = mysqli_query($con, $sql);
                $zhody = mysqli_num_rows($result);
                if($zhody > 0) {
                    $sql = "INSERT INTO `related`(`povodny_clanok_id`, `sug_clanok_id`, `zhody`) VALUES ('$last_id','$index',$zhody), ('$index','$last_id',$zhody)";
                    mysqli_query($con, $sql);
                }
            }
            echo "VŠETKO HOTOVO, ČLÁNOK PRIDANÝ";
        }  
    } 
    else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
        return -1;
    }
}

function related_clanky($clanok_id) {
    $con = $GLOBALS['conn'];
    $sql = "SELECT * FROM related INNER JOIN clanky ON sug_clanok_id=clanky.clanok_id WHERE povodny_clanok_id='$clanok_id' ORDER BY zhody DESC LIMIT 10";
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($con, $result)) {
            //rob si čo chceš
        }
    }
}

function injector($strana) { //1 2 3 4 Ňikolif 0
    $con = $GLOBALS['conn'];
    $expr1 = CLANKOV_NA_STRANU * ($strana - 1);
    $expr2 = CLANKOV_NA_STRANU + 1;
    $sql = "SELECT * FROM `clanky` ORDER BY clanok_id DESC LIMIT '$expr1','$expr2'";
    $result = mysqli_query($con, $sql);
    $pocitadlo = 0;
    while($row = mysqli_fetch_assoc($con, $result)) {
        if($pocitadlo < CLANKOV_NA_STRANU) {
            //ZOBRAZ ELEMENT
            $pocitadlo++;
        }
        else {
            //zobraz tlacidlo "ZOBRAZIT VIAC"
        }
    }
}

function article($url) {
    include'db.php';
    //$con = $GLOBALS['conn'];
    $sql = "SELECT * FROM clanky WHERE url='$url'";
    $result = mysqli_query($conn, $sql);
    if($result && mysqli_num_rows($conn, $result) == 1) {
        $vys = mysqli_fetch_assoc($result);
        
    }
}

function tagy($clanok_id) {
    include 'db.php';
    //$con = $GLOBALS['conn'];
    $sql = "SELECT * FROM tagy WHERE clanok_id='$clanok_id'";
    $result = mysqli_query($conn, $sql);
    $tag_arr = array();
    if($result && mysqli_num_rows($conn, $result) == 1) {
        while($v = mysqli_fetch_assoc($result)) {
            $tag_arr[] = $v["tag"];
        }
    }
    return implode(", ",$tag_arr)
}
?>