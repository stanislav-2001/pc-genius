<?php function get_last() {
        $files = scandir("../adminimages");
        $arr = [];

        
        foreach($files as $f) {
            $arr[$f] = filectime("../adminimages/".$f);
        }
        arsort($arr);
        return "adminimages/".array_keys($arr)[0];
    }
    echo get_last();
    ?>