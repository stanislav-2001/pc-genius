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
        <?php
            include 'db.php'; //NACITANIE DATABAZY DO PREMENNEJ $conn

            $url = $_GET["url"]; //NACITANIE URL z GET TODO: prepisat htaccess

            //SAFETY-CHECK: (404 ak url nie je v spravnom tvare)
            $url = $conn->real_escape_string($url); //PREVOD URL na bezpecny string
            echo "URL: $url"; //TODO: odstranit

            for($i = 0; $i < strlen($url); $i++) {
                if(($url[$i] >= 97 && $url[$i] <= 122) || $url[$i] === 45) { 
                    http_response_code(404);
                    die();
                }
            }

            $sql = "SELECT * FROM clanky WHERE url='$url'";
            $result = mysqli_query($conn, $sql);
            if($result && mysqli_num_rows($result) == 1) {
                $vys = mysqli_fetch_assoc($result);
            }

            
            // $vys -> asociativna premenna obsahujuca metadata o clanku
            // "clanok_id" , "nazov" , "html_obsah" , "url" , "obr_semiurl" , "kategoria" 

            function tagy($clanok_id) {
                $con = $GLOBALS['conn'];
                $sql = "SELECT * FROM tagy WHERE clanok_id='$clanok_id'";
                $result = mysqli_query($con, $sql);
                $tag_arr = array();
                if($result) {
                    while($v = mysqli_fetch_assoc($result)) {
                        $tag_arr[] = $v["tag"];
                    }
                }
                return implode(", ",$tag_arr);
            }
            $tagy = tagy($vys["clanok_id"]);
            $s = getimagesize(substr($vys["obr_semiurl"], 1));
        ?>
        <title><?php echo $vys["nazov"]; ?> - PCGENIUS</title>
        <link href="https://fonts.googleapis.com/css?family=Public+Sans:300,700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Varela+Round&display=swap" rel="stylesheet">
        <link href="../css/index.css" rel="stylesheet" type="text/css">
        <link href="../css/article.css" rel="stylesheet" type="text/css">
        <link href="../css/related.css" rel="stylesheet" type="text/css">
        <script src="https://kit.fontawesome.com/e1ab4aab0c.js" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?php echo $vys["nazov"]; ?>">
        <meta name="keywords" content="<?php echo strip_tags($tagy); ?>">
        <meta charset="UTF-8">
        <meta property="og:image" content="<?php echo 'https://pcgenius.xyz' . $vys['obr_semiurl']; ?>">
        <meta property="og:image:width" content="<?php echo $s[0]; ?>">
        <meta property="og:image:height" content="<?php echo $s[1]; ?>">
        <style>#gdpr-container > div { height: 0; overflow: hidden; }</style>
    </head>
    <body>
        <main id="body">
            <div id="titul" onclick="window.location.href='/'"> <?php //TODO: fullh ?>
                <h1>PC Genius</h1>
                <p>A brand new computer blog</p>
            </div>
            
            <section id="sleft">
                <div class="fill">
                    <div id="headbox" style="background-image:url('<?php echo $vys["obr_semiurl"]; ?>')">
                        <div id="headbox-overlay-fake"></div>
                        <div id="headbox-overlay">
                            <div class="rel">
                                <div class="center-text"><h1 style="font-size: calc(0.75em + 1vw)"><?php echo $vys["nazov"]; ?></h1></div>
                            </div>
                        </div>
                    </div>
                
                <div id="owned-html">
                <div class="addthis_inline_share_toolbox"></div>
                <?php echo $vys["html_obsah"]; ?>
                </div>
                <div id="disqus_thread"></div>
                <script>

                /**
                *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
                *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
                
                var disqus_config = function () {
                this.page.url = "<?php echo "https://pcgenius.xyz/article/" . $vys["url"] ?>";  // TODO: Replace PAGE_URL with your page's canonical URL variable
                this.page.identifier = <?php echo $vys["clanok_id"]; ?>; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                };
                
                (function() { // DON'T EDIT BELOW THIS LINE
                var d = document, s = d.createElement('script');
                s.src = 'https://pc-genius.disqus.com/embed.js';
                s.setAttribute('data-timestamp', +new Date());
                (d.head || d.body).appendChild(s);
                })();
                </script>
                <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                </div>
            </section>
            
            <aside id="sright">
                <div class="fill">
                    <section id="newsletter">
                        <h3 class="sectionheader">Newsletter</h3>
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
                        </div>
                    </section>
                    <section id="related-arts-section">
                        <?php 
                            function related_clanky($clanok_id) {
                                $prvacast = '<h3 class="sectionheader">Related articles</h3><div><div id="related-line">';
                                $druhacast = "</div></div>";
                                $vratka = "";
                                $con = $GLOBALS['conn'];
                                $sql = "SELECT * FROM related INNER JOIN clanky ON sug_clanok_id=clanky.clanok_id WHERE povodny_clanok_id='$clanok_id' ORDER BY zhody DESC LIMIT 10";
                                $result = mysqli_query($con, $sql);
                                if(mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        //rob si čo chceš TODO: DOKONČI
                                        $nadpis = $row["nazov"];
                                        $fname = "/"."article/" . $row["url"]; //TODO: HTACCESS
                                        $style = "url(". $row["obr_semiurl"] .")";

                                        $vratka .= <<<EOD
                                        <a class="related-box-item" href="$fname" style="background-image:$style">
                                            <div class="related-box-flyout">
                                                <div class="rel-x"><div class="center-text-x">$nadpis</div></div>
                                            </div>
                                        </a>
EOD;
                                    }
                                    echo $prvacast . $vratka . $druhacast;
                                }
                            }
                            related_clanky($vys["clanok_id"]);
                        ?>
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
                    <section onclick="cookies()" class="gdpr-btn">I agree</section>
                    <a href="/misc/disagree.html" class="gdpr-btn">I disagree</a>
                </section>
EOD;
            }
        ?>
        <section id="gdpr">
            <?php echo $ck; ?>
        </section>
        <script src="/index.js"></script>
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5e6be779cf8a42a1"></script>
        <script> </script>
    </body>
</html>