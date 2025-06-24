<?php 
    include 'db.php';
           $basic = "";
           $basic_btn = "";
           function injector($strana, $na_stranu) { //1 2 3 4 Ňikolif 0
               $con = $GLOBALS['conn'];

               $expr1 = $na_stranu * ($strana - 1) + 3;
               $expr2 = $na_stranu + 1;
               $sql = "SELECT * FROM `clanky` ORDER BY clanok_id DESC LIMIT '$expr1','$expr2'";
               $result = mysqli_query($con, $sql);
               $pocitadlo = 0;
               $basic_btn = "";
               while($row = mysqli_fetch_assoc($result)) {
                   if($pocitadlo < $na_stranu) {
                       //ZOBRAZ ELEMENT
                       $adresa = "/article.php?url=" . $row["url"]; //TODO: htaccess
                       $basic .= '<div class="basic">'.
                           '<a class="sub box" href="'.$adresa.'">'.
                               '<div class="rel">'.
                                   '<div class="fotka" id="f01" 
                                   style="background-image:url(\''.$row["obr_semiurl"].'\')"></div>'.
                                       '<header class="nadpis related-art-header"><div class="r"><span class="centext">'.$row["nazov"].'</span></div></header>'.
                                   '<div class="sipka"><i id="ikonka" class="fas fa-book-open"></i></div>'.
                               '</div>'.
                           '</a>'.
                       '</div>';
                       $pocitadlo++;
                   }
                   else {
                       //zobraz tlacidlo "ZOBRAZIT VIAC"
                       $basic_btn = "<div id='next-page' onclick='novastrana(".(intval($strana)+1).")'>Load more</div>"; //TODO: onclick()
                   }
               }
               return json_encode(array($basic,$basic_btn));
           }
           function bezpecnost($str) {
               for($a = 0; $a < strlen($str); $a++) {
                   $p = ord($str[$a]);
                   if($p < 48 || $p > 57) {
                       http_response_code(403);
                       die();
                   }
               }
               return $str;
           }
           $strana = bezpecnost($_GET["page"]);
           echo injector($strana, 10);


?>