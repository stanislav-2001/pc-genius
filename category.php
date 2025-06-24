<html>
    <head>
        <title>PCGENIUS</title>
        <link href="https://fonts.googleapis.com/css?family=Public+Sans:300,700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Varela+Round&display=swap" rel="stylesheet">
        <link href="css/index.css" rel="stylesheet" type="text/css">
        <script src="https://kit.fontawesome.com/e1ab4aab0c.js" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="UTF-8">
    </head>
    <body>
        <!--<nav id="mnav">
            <h1>PC Genius</h1>
        </nav>-->
        <?php 
            include 'config.php';
            $id = 0;
            if(isset($_GET["id"])) {
                $id = intval($_GET["id"]);
            }
            if(!file_exists("headlines.json")) file_put_contents("headlines.json", "[]");
            $data = file_get_contents("headlines.json");
            $clanky = json_decode($data, true);
            $category = "";
            //$clanky[] = array("img" => $fotka, "nadpis" => $nadpis, "tagy" => tagy_zo_stringu($tagy), "kategoria" => $kat);
            for($i = 0; $i < count($clanky); $i++) {
                if(intval($clanky[$i]["kategoria"]) === $id) {
                    $adresa = $BASE_URL . "arts/" . urlencode($clanky[$i]["nadpis"]) . ".php";
                    $category .= '<div class="basic">'.
                        '<div class="sub box" onclick="window.location.href=\''.$adresa.'\'">'.
                            '<div class="rel">'.
                                '<div class="fotka" id="f01" 
                                style="background-image:url(\''.$clanky[$i]["img"].'\')"></div>'.
                                    '<header class="nadpis related-art-header"><div class="r"><span class="centext">'.$clanky[$i]["nadpis"].'</span></div></header>'.
                                '<div class="sipka"><i id="ikonka" class="fas fa-book-open"></i></div>'.
                            '</div>'.
                        '</div>'.
                    '</div>';
                }
            }  
        ?>
        <main id="body">
            <div id="titul" onclick="window.location.href='<?php echo $BASE_URL.'index.php'; ?>'">
                <h1>PC Genius</h1>
                <p>A brand new computer blog</p>
            </div>
            <section id="frontline">
            <div id="first">
                <div class="sub" onclick="window.location.href='<?php echo $adr1; ?>'">
                    <div class="rel" style="background-image:url('<?php echo $clanky[0]["img"]; ?>')">
                        <header class="fnadpis"><span class="centext"><?php echo $clanky[0]["nadpis"]; ?></span></header>
                    </div>
                </div>
            </div>
            <div class="second">
                <div class="sub" onclick="window.location.href='<?php echo $adr2; ?>'">
                    <div class="rel" style="background-image:url('<?php echo $clanky[1]["img"]; ?>')">
                        <header class="snadpis"><span class="centext"><?php echo $clanky[1]["nadpis"]; ?></span></header>
                    </div>
                </div>
            </div>
            <div class="second">
                <div class="sub" onclick="window.location.href='<?php echo $adr3; ?>'">
                    <div class="rel" style="background-image:url('<?php echo $clanky[2]["img"]; ?>')">
                        <header class="snadpis"><span class="centext"><?php echo $clanky[2]["nadpis"]; ?></span></header>
                    </div>
                </div>
            </div>
            </section>
            
            <section id="sleft">
                <div class="fill">
                    <h2 class="sectionheader left">Category </h2>
                    <?php echo $category; ?>
                </div>
            </section>
            
            <aside id="sright">
                <div class="fill">
                    <h2 class="sectionheader right">Navigation</h2>
                    <nav id="navright" class="relvyp">
                        <div class="navitemwrapper">
                            <!--<div class="navitem">
                                <div class="navitemoverlay"></div>
                                <div class="navitemtext">Faskuska</div>
                            </div>
                            <div class="navitem">
                                <div class="navitemoverlay"></div>
                                <div class="navitemtext">Jeden</div>
                            </div>
                            <div class="navitem">
                                <div class="navitemoverlay"></div>
                                <div class="navitemtext">Dva</div>
                            </div>
                            <div class="navitem">
                                <div class="navitemoverlay"></div>
                                <div class="navitemtext">Dva</div>
                            </div>-->
                            <?php 
                                include 'load_cats.php';
                                echo load_cats();
                            ?>
                        </div>
                        <div class="navitemfill"></div>
                        <!--<script>
                            var niv = document.getElementById("navitemwrapper")[0];
                            let niv_xhr = new XMLHttpRequest();
                            niv_xhr.onreadystatechange = function() {
                                if(nix_xhr.status === 200 && nix_xhr.readyState === 4) {

                                }
                            };
                        </script>-->
                    </nav>
                    <section id="newsletter">
                        <h2 class="sectionheader">Newsletter</h2>
                        <div>
                            <div class="relvyp">
                                <div class="italic">Sign up for a free newsletter: get an email everytime when a new article is on.
                                    <div id="newslettermsgs"></div>
                                </div>
                                <input id="newsinput" type="email" placeholder="e.g. blahblah@blah.blah">
                                <div class="navitem" style="margin-top: 8px" onclick="send()">
                                    <div class="navitemoverlay"></div>
                                    <div class="transp"></div>
                                    <div class="navitemtext">Sign up!</div>
                                </div>
                                <div class="transp"></div>
                            </div>
                            <script src="index.js"></script>
                        </div>
                    </section>
                </div>
            </aside>
        </main>
        <script> </script>
    </body>
</html>