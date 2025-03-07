<?php

$avatar_url = "https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwww.pngmart.com%2Ffiles%2F21%2FAdmin-Profile-PNG-Clipart.png&f=1&nofb=1&ipt=b8007091a8c5a9ff0e0f2b21c3496e008afa90088db4b52b7a3b3a19af86f195&ipo=images";
$firstname = "Jan";
$lastname = "Novak";
$dob = "10.1.2004";
$occupation = "Programator";
$company = "Koogle";
$street = "Bruselska";
$zip = "18600";
$street_number = "40";
$city = "Praha";
$phone_num = "944 743 293";
$email = "novak@seznam.cz";
$web="https://www.novak.com";
$open_to_work = true;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        a {
            color: white;
        }
        .wrapper {
            display: flex;
            flex-direction: column;
            width: 50%;
            margin-left: auto;
            margin-right: auto;
        }
        .wrapper > div {
            margin: 1em;
            padding: 1em;
            background-color: darkslategray;
        }
        .front {
            display: flex;
            flex-direction: column;
            height: 15em;
        }
        .horizontal {
            width: 100%;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
        .horizontal > div {
            width: 45%;
        }
        .avatar {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .avatar img {
            max-width: 80%;
        }
        .back {
            height: 15em;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .columns {
            width: 100%;
            display: flex;
            flex-direction: row;
        }
        .back .col {
            width: 45%;
        }
        .front , .back {
            color: white;
            font-size: large;
            font-family: Arial, Helvetica, sans-serif;
        }
        .otv {
            color: green;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="front">
            <div class="horizontal">
                <div class="avatar">
                    <img src="<?=$avatar_url?>" alt="">
                </div>
                <div class="info">
                    <h1><?=$firstname?> <?=$lastname?></h1>
                    <h3><?=$occupation?> at <?=$company?></h3>
                    <?php
                        if ($open_to_work) {
                            echo "<h3 class=\"otv\">-> Open to work</h3>";
                        }
                    ?>
                </div>

            </div>
            <p></p>
        </div>
        <div class="back">
            <h3>Kontakt:</h3>
            <div class="columns">
                <ul class="col">
                    <li><?=$firstname?> <?=$lastname?></li>
                    <li><?=$street?> <?=$street_number?></li>
                    <li><?=$zip?></li>
                    <li><?=$city?></li>
                </ul>
                <ul class="col">
                    <li><a href="<?=$phone_num?>"><?=$phone_num?></a></li>
                    <li><a href="<?=$email?>"><?=$email?></a></li>
                    <li><a href="<?=$web?>"><?=$web?></a></li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>