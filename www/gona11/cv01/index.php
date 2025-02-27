<?php 

$first_name = 'Andrej'; 
$last_name = 'Gončarov';
$age = 21; 
$position = 'Student VŠE FIS';
$adress = 'Grafická 950/22';
$city = 'Praha 5';
$code = 15000;
$phone = '+420603966663';
$email = 'a.goncarov@outlook.cz';
$seeking_job = "Avalible for contracts";
$instagram = "AndyGoncy";
$github = "AndyTheDev";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <!-- odkazy na ikony -->
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
        <title>Andrej Gončarov</title>
    </head>
    <body>
        <div class="box box_front">
            <div class="align_left">
                <img class="avatar" src="resources/avatar.jpg" alt="" srcset="">
            </div>

            <div class="align_right">
                <div class="background_right"></div>
                <div class="right_top">
                    <h1><?php echo $first_name?></h1>
                    <h1><?php echo $last_name?></h1>
                    <p><?php echo $age?> || <?php echo $position?></p>
                </div>
                <div class="right_bottom">
                    <div class="info_inline">
                        <span class="material-symbols-outlined">call</span>
                        <p><?php echo $phone?></p>
                    </div>

                    <div class="info_inline">
                        <span class="material-symbols-outlined">mail</span>
                        <p><?php echo $email?></p>
                    </div>
                 
                    <div class="info_inline">
                        <span class="material-symbols-outlined">home</span>
                        <p><?php echo $adress?></p>
                    </div>

                    <div class="info_inline">
                        <span class="material-symbols-outlined">location_city</span>
                        <p><?php echo $city?>, <?php echo $code?></p>
                    </div>
                    
                    <p><?php echo $seeking_job?></p>
                </div>
            </div>
        </div>

        <div class="box box_back">
            <h1><?php echo $first_name. " " .$last_name?></h1>
            <div class="divider"></div>
            <div class="info_inline">
                <img class="logo" src="resources/instagram.png" alt="" srcset="">
                <p><?php echo $instagram?></p>
            </div>
            <div class="info_inline">
                <img class="logo" src="resources/github.png" alt="">
                <p><?php echo $github?></p>
            </div>
        </div>
        <div class="foot">
            <a href="https://www.flaticon.com/free-icons/instagram" title="instagram icons">Instagram icons created by edt.im - Flaticon</a>
            <br>
            <a href="https://www.flaticon.com/free-icons/github" title="github icons">Github icons created by Pixel perfect - Flaticon</a>
        </div>
    </body>
</html>

