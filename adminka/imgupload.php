



<?php
    include 'adminka_bcg.php';
    $subor = $_FILES['subor'];
    //echo var_dump($_FILES["subor"]);
    //if(empty($_FILES["subor"])) echo "empty";
    $nazov = $subor['name'];
    //echo $nazov;
    //ini_set('memory_limit', '128M');
    $exts = array("png","jpg","jpeg","webp","gif");
    $bezpripony = "";
    //echo "CHYBA 4.3 " . print_r($_FILES['subor']) . "nazov" . $nazov;
    $bezpripony = pathinfo($nazov, PATHINFO_FILENAME); 
    //echo "CHYBA 4.3 " . print_r($_FILES['subor']) . "bezpripony " . $bezpripony;
    
    function mechanizmus($oldstr) {
        $oldstr = strtolower($oldstr);
        $newstr = "";
        for($i = 0; $i < strlen($oldstr); $i++) {
            $char = substr($oldstr, $i, 1);
            if(ord($char) >= 97 && ord($char) <= 122) {
                $newstr .= $char;
            }
            else if(ord($char) === 32) {
                $newstr .= "_";
            }
        }
        return $newstr;
    }
    $bezpripony = mechanizmus($bezpripony);
    $nazov = $bezpripony . ".webp";
    //echo $nazov;
    $loc = "../adminimages/" . $nazov;
    $ext = strtolower(pathinfo($_FILES['subor']['name'])['extension']);
    if(in_array($ext, $exts)) {
        compress($subor["tmp_name"],$loc,60,$bezpripony);
    }
    else echo "H";
    function compress($oldloc, $newloc, $q, $bezp) {
        
        $size = getimagesize($oldloc);
        if($size == false) echo "H";
        //echo var_dump($size);
        //echo "ABSD";
        //echo "MIME: " .$size["mime"] . "\n";
        switch($size["mime"]) {
            case "image/png":
                $image = imagecreatefrompng($oldloc);
                break;
            case "image/jpeg":
                $image = imagecreatefromjpeg($oldloc);
                break;
            case "image/webp":
                $image = imagecreatefromwebp($oldloc);
                break;
            case "image/gif":
                $image = imagecreatefromgif($oldloc);
                break;
            default:
                $image = "H";
                echo "H";
        }
        if($image != "H") {
            $pomocny = 1;
            while(file_exists($newloc)) {
                $newloc = "../adminimages/" . $bezp . "_" . $pomocny . ".webp";
                $pomocny++;
            }
            //file_put_contents("aploud.txt", $newloc);
            imagewebp($image, $newloc, $q);
            echo get_imgs();
        }
    }
?>