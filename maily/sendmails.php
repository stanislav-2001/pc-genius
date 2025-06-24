<?php
    //newsletters
    function send_mails($nadpis, $img, $href) { //img, href = semi adresa
        if(!file_exists("emails.json")) file_put_contents("emails.json", "[]");
        $data = file_get_contents("emails.json");
        $emaily = json_decode($data, true);
        //$modifikovana = substr($BASE_URL,0,-1);
        foreach(array_keys($emaily) as $email) {
            $to = $email;
            $hash = $emaily[$to];
            $html = <<<EOD
            <html lang="en">
            <head>
                <link href="https://fonts.googleapis.com/css?family=Varela+Round&display=swap" rel="stylesheet">
                <meta charset="UTF-8">
                <style>
                    body {
                        font-family: 'Varela Round', sans-serif;
                        max-width: 600px;
                    }
                    main {
                        background-color: #ecf0f1;
                        text-align: center;
                    }
                    #logo {
                        height: 80px;
                        display: inline-block;
                        padding-top: 20px;
                    }
                    #imglogo {
                        height: 100%;
                        float: left;
                    }
                    h1 {
                        float: left;
                        padding-left: 10px;
                        color: #2c3e50;
                    }
                    h2 {
                        text-align: center;
                        color: #2c3e50;
                        margin-bottom: 0;
                    }
                    h3 {
                        margin-top: 0;
                        padding-left: 20px;
                        padding-right: 20px;
                        color: #ecf0f1;
                        text-align: center;
                    }
                    #red {
                        background-color: #e74c3c;
                    }
                    #artpic {
                        width: 100%;
                        padding: 20px;
                        box-sizing: border-box;
                        border-radius: 28px;
                    } 
                    #artbtn {
                        width: 50%;
                        height: 50px;
                        background-color: #2c3e50;
                        display: block;
                        margin-left: auto;
                        margin-right: auto;
                        line-height: 50px;
                        color: #ecf0f1;
                        text-align: center;
                    }
                    p {
                        color: #ecf0f1;
                        margin: 0;
                        padding: 0;
                        text-align: center;
                    }
                    #black {
                        background-color: #2c3e50;
                        padding: 20px;
                        box-sizing: border-box;
                    }
                    #space {
                        height: 20px;
                        width: 100%;
                    }
                    #here {
                        color: #e74c3c;
                    }
                    #segment {
                        text-align: center;
                        background-color: #ecf0f1;
                        padding-bottom: 20px;
                        text-align: center;
                    }
                </style>
            </head>
            <body>
                <main>
                    <div id="segment" align="center">
                        <div id="logo">
                            <img id="imglogo" src="https://pcgenius.xyz/pcgenius_logo.png">
                            <h1>PC Genius</h1>
                        </div>
                        <h2>A new article has been published</h2>
                    </div>
                    <div id="red">
                        <img id="artpic" src="https://pcgenius.xyz$img" alt="Article image">
                        <h3 align="center">$nadpis</h3>
                        <a id="artbtn" href="https://pcgenius.xyz/article$href" align="center">Read article</a>
                        <div id="space"></div>
                    </div>
                    <div id="black">
                        <p align="center">You've got this email because you have signed up for a newsletter on PC Genius. If you don't want to receive these emails anymore, or you think that your email adress was abused, you can click <a href="https://pcgenius.xyz/removenewsletter.php?mail=$to&code=$hash"" id="here">here</a> to remove your email address from our database.</p>
                    </div>
                </main>
            </body>
        </html>
EOD;
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: PCGenius Newsletter <newsletter@pcgenius.xyz>' . "\r\n";
            mail($to, $nadpis ." - PC Genius", $html, $headers);   
            //echo $html;
            
        }
    }
?>