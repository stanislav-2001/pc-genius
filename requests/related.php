<?php 
    if(!isset($_GET["id"])) die();
    $id = $_GET["id"];
    $vratka = "";
    $headlines = file_get_contents("../headlines.json"); 
    $headlines = json_decode($headlines, true);
    $nasetagy = "";
    foreach($headlines as $clanok) {
        if(intval($clanok["id"]) === intval($id)) {
            $nasetagy = $clanok["tagy"];
        }
    }
    $vysledkove = array();
    foreach($headlines as $clanok) {
        if(intval($clanok["id"]) !== intval($id)) {
            $zhody = 0;
            foreach($nasetagy as $nastag) {
                foreach($clanok["tagy"] as $ichtag) {
                    if($nastag === $ichtag) $zhody++;
                }
            }
            $vysledkove[] = array( "id" => $clanok["id"], "zhody" => $zhody, "nazov" => $clanok["nadpis"], "obrazok" => $clanok["img"]); 
            //$vysledkove[$clanok["id"]] = $zhody;
            //echo " cl " . $clanok["id"] . " " . $zhody; 
        }
    }
    array_multisort(array_column($vysledkove,"zhody"), SORT_DESC, $vysledkove);
    $ind = 0;
    include "../config.php";
    while($ind < count($vysledkove) && $vysledkove[$ind]["zhody"] > 0) {
        
        $nadpis = $vysledkove[$ind]["nazov"];
        $obrazok = $vysledkove[$ind]["obrazok"];
        $novy_nadpis = str_replace(" ","+",$nadpis);

        $htmlname = "arts/" . urlencode($novy_nadpis) . ".php";
        $fname = $BASE_URL.$htmlname;
        $style = "url('". $obrazok ."');";
        $vratka .= <<<EOD
            <a class="related-box-item" href="$fname" style="background-image:$style">
                <div class="related-box-flyout">
                    <div class="rel-x"><div class="center-text-x">$nadpis</div></div>
                </div>
            </a>
EOD;
        $ind++;
    }
    $prvacast = '<h3 class="sectionheader">Related articles</h3><div><div id="related-line">';
    $druhacast = "</div></div>";
    if($vratka === "") {
        echo "";
    }
    else echo $prvacast . $vratka . $druhacast;
?>