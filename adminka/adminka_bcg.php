<?php
    function get_imgs() {
        $files = scandir("../adminimages");
        $arr = [];
        foreach($files as $f) {
            if(substr($f, 0, 1) !== ".") {
                $arr[$f] = filectime("../adminimages/".$f);
            }
        }
        arsort($arr);
        $vys = "";
        foreach($arr as $k => $v) {
            $pd = "pridajObrazok(\"/adminimages/".$k."\")";
            $vys .= "<div class='img-member'>".
                "<div class='img-actual' style='background-image:url(\"/adminimages/".$k."\")' onclick='".$pd."'></div>".
            "</div>";
        }
        return $vys;
    }

    if(isset($_GET["fun"])) {
        if($_GET["fun"] === "last") {
            echo get_last();
        }
    }

    function get_last() {
        $files = scandir("../adminimages");
        $arr = [];

        
        foreach($files as $f) {
            if(substr($f, 0, 1) !== ".") {
                $arr[$f] = filectime("../adminimages/".$f);
            }
        }
        arsort($arr);
        return "/" . "adminimages/".array_keys($arr)[0];
    }
?>