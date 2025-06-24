<?php
    //newsletters
    include 'config.php';
    function send_mails($nadpis, $img, $href) {
        include 'config.php';
        if(!file_exists("emails.json")) file_put_contents("emails.json", "[]");
        $data = file_get_contents("emails.json");
        $emaily = json_decode($data, true);
        $modifikovana = substr($BASE_URL,0,-1);
        foreach(array_keys($emaily) as $email) {
            $to = $email;
            $hash = $emaily[$to];
            $html = <<<EOD
                    <html>
                        <head>
                            <meta charset="UTF-8">
                            <link href="https://fonts.googleapis.com/css?family=Varela+Round&display=swap" rel="stylesheet">
                        <style>
                        body {
                            font-family: 'Varela Round','Public Sans', sans-serif;
                            background-color: #ecf0f1;
                        }
                        h1, p {
                            margin-left: 10px;
                            color: #2c3e50;
                        }
                        #first {
                            /*background-color: green;*/
                            width: 50%;
                            height: 400px;
                            position: relative;
                            display: block;
                        }
                        #first:hover {
                            cursor: pointer;
                        }
                        
                        .sub {
                            position: absolute;
                            left: 10px;
                            top: 10px;
                            right: 10px;
                            bottom: 10px;
                            background-color: #2c3e50;
                            border-radius: 8px;
                            transition: 0.7s;
                            color: #ecf0f1;
                            box-shadow:
                            0 2.8px 2.2px rgba(0, 0, 0, 0.034),
                            0 6.7px 5.3px rgba(0, 0, 0, 0.048),
                            0 12.5px 10px rgba(0, 0, 0, 0.06),
                            0 22.3px 17.9px rgba(0, 0, 0, 0.072),
                            0 41.8px 33.4px rgba(0, 0, 0, 0.086),
                            0 100px 80px rgba(0, 0, 0, 0.12)
                        }
                        
                        .rel {
                            width: 100%;
                            height: 100%;
                            position: relative;
                            border-radius: inherit;
                            background-size: cover;
                        }
                        .fnadpis {
                            position: absolute;
                            bottom: 0;
                            left: 0;
                            right: 0;
                            top: 65%;
                            background-color: #e74c3c;
                            border-radius: 0 0 8px 8px;
                            font-size: calc(0.75em + 1vw);
                        }
                        .centext {
                            position: absolute;
                            top: 50%;
                            transform: translateY(-50%);
                            text-align: center;
                            left: 10px;
                            right: 10px;
                        }
                        p a {
                            color: #e74c3c;
                        }
                        </style>
                        </head>
                        <body>
                            <h1>A new article on PC Genius has been published</h1>
                            <a id="first" href="$href">
                                <div class="sub">
                                    <div class="rel" style="background-image: url('$img');">
                                        <header class="fnadpis"><span class="centext">$nadpis</span></header>
                                    </div>
                                </div>
                            </a>
                            <p>If you did not subscribe to the newsletter, or you simply do not want to receive emails from PC Genius anymore, you can cancel the subscription by clicking <a href="$modifikovana/removenewsletter.php?mail=$to&code=$hash">here</a>.</p>
                        </body>
                    </html>
EOD;
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: <newsletter@pcgenius.xyz>' . "\r\n";
            mail($to, $nadpis ." - PC Genius", $html, $headers);   
            echo $html;
            
        }
    }
?>