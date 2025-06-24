<?php 

include "db.php";

$string = urldecode($_POST["objstring"]);
$obj = json_decode($string, true);

$nadpis = mysqli_real_escape_string($obj["nadpis"]);
$clanok = mysqli_real_escape_string($obj["clanok"]);
$fotka = mysqli_real_escape_string($obj["fotka"]); //TODO: uistit sa ze ide o semiurl v tvare "/adminimages/skuska.webp" !important
$tagy = mysqli_real_escape_string(strip_tags($obj["tagy"]));
$kat = mysqli_real_escape_string($obj["kategoria"]);

function konvertuj($tgs) {
    $tga = explode(";", $tgs);
    return implode(", ", $tga);
}

$kw = konvertuj($tagy);
$kw = array_unique($kw);

function clanok($nazov, $html_obsah, $url, $obr_semiurl, $kategoria, $tagy) { //assuming že $tagy = distinct array
    $con = $GLOBALS['conn'];
    /*$nazov = mysqli_real_escape_string($con, $nazov);
    $html_obsah = mysqli_real_escape_string($con, $html_obsah);
    $url = mysqli_real_escape_string($con, $url);
    $obr_semiurl = mysqli_real_escape_string($con, $obr_semiurl);*/
    $sql = "INSERT INTO clanky (nazov, html_obsah, url, obr_semiurl, kategoria)
    VALUES ('$nazov', '$html_obsah', '$url', '$obr_semiurl', '$kategoria')";

    if (mysqli_query($con, $sql)) {
        $last_id = mysqli_insert_id($con);
        //echo "New record created successfully. Last inserted ID is: " . $last_id;
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
                    $sql = "INSERT INTO `related`(`povodny_clanok_id`, `sug_clanok_id`, `zhody`) VALUES ('$last_id','$index','$zhody'), ('$index','$last_id','$zhody')";
                    mysqli_query($con, $sql);
                }
            }
            echo "OK";
        }  
    } 
    else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
        //return -1;
    }
}

clanok($nadpis, $clanok, $fotka, $tagy, $kat);

?>