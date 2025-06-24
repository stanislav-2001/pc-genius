<!DOCTYPE html>
<html>
    <head>
        <?php include 'adminka_bcg.php'; ?>
        <?php include '../load_cats.php'; ?>
        <?php
            if(!isset($_GET["pass"]) || $_GET["pass"] !== sha1("adminheslo2025!")) {
            http_response_code(404);
            include('../404.html');
            die();
            }
        ?>
        <title>PCGENIUS</title>
        <link href="https://fonts.googleapis.com/css?family=Public+Sans:300,700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Varela+Round&display=swap" rel="stylesheet">
        <link href="../css/index.css" rel="stylesheet" type="text/css">
        <link href="../css/adminka.css" rel="stylesheet" type="text/css">
        <script src="https://kit.fontawesome.com/e1ab4aab0c.js" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="UTF-8">
    </head>
    <body>
        <!--<nav id="mnav">
            <h1>PC Genius</h1>
        </nav>-->
        <div id="admin-notif">
            NACHÁDZATE SA V ADMINISTRÁCII
        </div>
        <main id="body">
            <div id="titul">
                <h1>PC Genius</h1>
                <p>A brand new computer blog</p>
            </div>
            
            <section id="sleft">
                <h1 class="sectionheader left" id="art-header" contenteditable>Nadpis článku - zmeň ma</h1>
                <input type="file" class="new-input-file" id="main-pic-inp" onchange="zmena(this, true)">
                <label for="main-pic-inp" class="art-image-set" id="main-pic">
                    <div class="center-text" id="main-pic-ct"><i class="fas fa-image" style="font-size: 4em"></i><br>Pridajte hlavný obrázok</div>
                </label>
                <div class="art-controller">
                    <div id="img-btn" onclick="zatagovat('h2')" class="img-member"><div class="center-text"><i class="fas fa-heading" style="font-size: 2em;"></i><br>Nadpis</div></div>
                    <div id="img-btn" onclick="zatagovat('p')" class="img-member"><div class="center-text"><i class="fas fa-paragraph" style="font-size: 2em;"></i><br>Odsek</div></div>
                    <div id="img-btn" onclick="document.execCommand('bold',true)" class="img-member"><div class="center-text"><i class="fas fa-bold" style="font-size: 2em;"></i><br>Hrubý text</div></div>
                    <div id="img-btn" onclick="document.execCommand('italic',true)" class="img-member"><div class="center-text"><i class="fas fa-italic" style="font-size: 2em;"></i><br>Šikmý text</div></div>
                    <div id="img-btn" onclick="obrazokMenu('a-ctxmenu','a-nim-ctxmenu', 0)" class="img-member"><div class="center-text"><i class="fas fa-link" style="font-size: 2em;"></i><br>Odkaz</div></div>
                    <div id="img-btn" onclick="obrazokMenu('img-ctxmenu','anim-ctxmenu', 1)" class="img-member"><div class="center-text"><i class="fas fa-images" style="font-size: 2em;"></i><br>Vložiť obrázok</div></div>
                    <div id="img-btn" onclick="pridajObrazok()" class="img-member"><div class="center-text"><i class="fas fa-table" style="font-size: 2em;"></i><br>Vložiť tabuľku</div></div>
                </div>
                <div id="img-ctxmenu" class="top-ctxmenu">
                    <div id="anim-ctxmenu" class="opacity">
                        <h4>Aký obrázok?</h4>
                        <div id="img-spread">
                            <?php echo get_imgs(); ?>
                        </div>
                        <label for="img-manual" class="new-input-file-label">NAHRAŤ NOVÝ</label>
                        <input type="file" class="new-input-file" id="img-manual" onchange="zmena(this)">
                        <div id="dragdropcover">
                            <div class="center-text">DROP IMAGE HERE</div>
                        </div>
                    </div>
                </div>
                <div id="a-ctxmenu" class="top-ctxmenu">
                    <div id="a-nim-ctxmenu" class="opacity">
                        <h4>Aká je adresa odkazu?</h4>
                        <input type="text" class="new-input-text" id="vlozit-link">
                        <h4>Čím sa má odkaz zakryť?</h4>
                        <input type="text" class="new-input-text" id="vlozit-text"><br>
                        <div class="new-input-file-label" id="vlozit-odkaz">VLOŽIŤ</div>
                    </div>
                </div>
                <div class="art-txt" id="art-txt" placeholder="Začnite písať článok sem..." focus="true" contenteditable>

                </div> 
            </section>
            
            <aside id="sright">
                <div id="div-right">
                    <div id="publish-button" onclick="publikovat()"><i class="fas fa-upload" style="font-size: 2em; vertical-align: sub; padding-right: 10px;"></i>Zverejniť</div>
                    <section id="tag-section">
                        <div id="tag-section-direct">TAGY</div>
                        <div id="tag-section-textarea" placeholder="AMD, Intel, Core, Ryzen...." contenteditable>Skuska</div>
                    </section>
                    <section id="category-section">
                        <div id="category-section-direct">KATEGÓRIA</div>
                        <?php echo get_cats(); ?>
                        <!-- TODO: Nova Kategoria -->
                    </section>
                </div>
            </aside>
        </main>
        <script src="../index.js"></script>
        <script src="adminka.js"></script>
        <script> </script>
    </body>
</html>