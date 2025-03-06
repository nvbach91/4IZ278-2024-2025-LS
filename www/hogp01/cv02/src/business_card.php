<?php foreach($persons as $person): ?>
        <div class="front">
            <div class="horizontal">
                <div class="avatar">
                    <img src="<?=$person->avatar?>" alt="">
                </div>
                <div class="info">
                    <h1><?=$person->getFullName();?></h1>
                    <h3><?=$person->field_of_work?> at <?=$person->company?></h3>
                    <?php
                        if ($person->open_to_work) {
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
                    <li><?=$person->firstname?> <?=$person->surname?></li>
                    <li><?=$person->street?> <?=$person->street_number?></li>
                    <li><?=$person->zip?></li>
                    <li><?=$person->city?></li>
                </ul>
                <ul class="col">
                    <li><a href="<?=$person->phone_number?>"><?=$person->phone_number?></a></li>
                    <li><a href="<?=$person->email?>"><?=$person->email?></a></li>
                    <li><a href="<?$person->web?>"><?=$person->web?></a></li>
                </ul>
            </div>
        </div>
        <?php endforeach;?>