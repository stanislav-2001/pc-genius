<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-159922269-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            
            gtag('config', 'UA-159922269-1');
        </script>
        <title>PC Genius</title>
        <link href="https://fonts.googleapis.com/css?family=Public+Sans:300,700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Varela+Round&display=swap" rel="stylesheet">
        <link href="css/index.css" rel="stylesheet" type="text/css">
        <script src="https://kit.fontawesome.com/e1ab4aab0c.js" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="computers, smartphones, processors, graphics cards, nvidia, intel, windows, news">
        <meta name="description" content="Brand new blog about software, computers, smartphones and computer components">
        <meta charset="UTF-8">
    </head>
    <body>
        <!--<nav id="mnav">
            <h1>PC Genius</h1>
        </nav>-->
        <?php 
            include 'db.php';
            $con = $conn;

            $sql = "SELECT * FROM `clanky` ORDER BY clanok_id DESC LIMIT 0,14";
            $result = mysqli_query($con, $sql);
            $pocitadlo = 0;
            $basic = "";
            $basic_btn = "";

            $clanky = array();

            while($row = mysqli_fetch_assoc($result)) {
                if($pocitadlo < 13 && $pocitadlo > 2) {
                   //ZOBRAZ ELEMENT
                    $adresa = "/article"."/" . $row["url"]; //TODO: htaccess
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
                }
                else if($pocitadlo < 3) {
                    $clanky[] = $row;
                }
                else if($pocitadlo === 13) {
                    //zobraz tlacidlo "ZOBRAZIT VIAC"
                    $basic_btn = "<div id='next-page' onclick='novastrana(2)'>Load more</div>"; //TODO: onclick()
                }
                $pocitadlo++;
            }

            for($i = count($clanky); $i < 3; $i++) {
                $clanky[] = array(
                    "url" => "empty",
                    "obr_semiurl" => "https://pcgenius.xyz/img/empty.png",
                    "nazov" => "Placeholder pre článok #" . ($i + 1)
                );
            }
        ?>
        <main id="body">
            <div id="fb-root"></div>
            <script async defer crossorigin="anonymous" src="https://connect.facebook.net/sk_SK/sdk.js#xfbml=1&version=v6.0"></script>
            <div id="titul" onclick="window.location.href='/'">
                <h1>PC Genius</h1>
                <p>A brand new computer blog</p>
            </div>
            <section id="frontline">
            <div id="first"> <!--TODO: HTACCESS!!!-->
                <a class="sub" href="<?php echo "/article"."/" . $clanky[0]["url"]; ?>">
                    <div class="rel" style="background-image:url('<?php echo $clanky[0]["obr_semiurl"]; ?>')">
                        <header class="fnadpis"><span class="centext"><?php echo $clanky[0]["nazov"]; ?></span></header>
                    </div>
                </a>
            </div>
            <div class="second">
                <a class="sub" href="<?php echo "/article"."/" . $clanky[1]["url"]; ?>">
                    <div class="rel" style="background-image:url('<?php echo $clanky[1]["obr_semiurl"]; ?>')">
                        <header class="snadpis"><span class="centext"><?php echo $clanky[1]["nazov"]; ?></span></header>
                    </div>
                </a>
            </div>
            <div class="second">
                <a class="sub" href="<?php echo "/article"."/" . $clanky[2]["url"]; ?>">
                    <div class="rel" style="background-image:url('<?php echo $clanky[2]["obr_semiurl"]; ?>')">
                        <header class="snadpis"><span class="centext"><?php echo $clanky[2]["nazov"]; ?></span></header>
                    </div>
                </a>
            </div>
            </section>
            
            <section id="sleft">
                <div class="fill">
                    <h2 class="sectionheader left">Older blogs</h2>
                    <div id="basic-box"><?php echo $basic; ?>
                    </div>
                    <div id="next-page-box"><?php echo $basic_btn; ?></div>
                    <script>
                    function novastrana(x) {
                        let xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function() {
                            if(xhr.readyState === 4 && xhr.status === 200) {
                                console.log(xhr.response);
                                let obj = JSON.parse(xhr.response);
                                document.getElementById("basic-box").innerHTML += obj[0];
                                document.getElementById("next-page-box").innerHTML = obj[1];
                            }
                        };
                        xhr.open("GET","injector.php?page=" + x);
                        xhr.send();
                    }
                    </script>
                </div>
            </section>
            
            <aside id="sright">
                <div class="fill">
                    <!--<h2 class="sectionheader right">Navigation</h2>
                    <nav id="navright" class="relvyp">
                        <div class="navitemwrapper">
                            <?php 
                                //include 'load_cats.php';
                                //echo load_cats();
                            ?>
                        </div>
                        <div class="navitemfill"></div>
                        <script>
                            var niv = document.getElementById("navitemwrapper")[0];
                            let niv_xhr = new XMLHttpRequest();
                            niv_xhr.onreadystatechange = function() {
                                if(nix_xhr.status === 200 && nix_xhr.readyState === 4) {

                                }
                            };
                        </script>
                    </nav>-->
                    <h2 class="sectionheader" style="padding-bottom: 10px">Our Facebook</h2>
                    <section id="fakebook-section">
                        
                        <div class="fb-page" data-href="https://www.facebook.com/PCGeniusxyz-100529078254084" data-tabs="timeline" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/PCGeniusxyz-100529078254084" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/PCGeniusxyz-100529078254084">PCGenius.xyz</a></blockquote></div>
                    </section>
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
        <?php 
            $ck = "";
            if(!isset($_COOKIE["gdpr"])) {
                $ck = <<<EOD
                <section id="gdpr-container">
                    <p>By using our website you have to agree with our <a href="/misc/privacypolicy.html">Privacy Policy</a>.</p>
                    <div onclick="cookies()" class="gdpr-btn">I agree</div>
                    <a href="/misc/disagree.html" class="gdpr-btn">I disagree</a>
                </section>
EOD;
            }
        ?>
        <section id="gdpr">
            <?php echo $ck; ?>
        </section>
        <script> </script>
    </body>
</html>