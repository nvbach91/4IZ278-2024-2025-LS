<?php foreach ($persons as $person): ?>
    <div class="center-screen">
        <div class="business-card"> <!-- front -->
            <br>
            <p class="name" style="color: red; "><?php echo $person->name; ?></p>
            <p class="name" style="color: blue;"><?php echo $person->surname; ?></p><br>
            <p class="title"><?php echo $person->slogan1; ?></p><br>
            <p class="title"><?php echo $person->slogan2; ?></p><br>
            <img src="icons/phone.svg" class="phoneNumber-icon" alt="PhoneNumber">
            <p class="phoneNumber-text" style="font-size: 30px; display: inline;"><?php echo $person->phoneNumber; ?></p>
        </div>
        <br>
        <div class="business-card"> <!-- back -->
            <div class="back">
                <p>
                    <img src="icons/job.svg" class="icon" alt="Job">
                    <?php echo $person->occupation; ?><br>
                    <img src="icons/age.svg" class="icon" alt="Age">
                    <?php echo $person->getAge(); ?> years old<br>
                    <img src="icons/address.svg" class="icon" alt="Address">
                    <?php echo $person->getAdress(); ?><br>
                    <img src="icons/mail.svg" class="icon" alt="Mail">
                    <?php echo $person->email; ?><br>
                    <a href="<?php echo $person->website_link; ?>" target="_blank">
                        <img src="icons/website.svg" class="icon" alt="Website">
                        <?php echo $person->website; ?>
                    </a><br>
                    <img src="<?php echo $person->logo; ?>" alt="Logo" class="logo">
                </p>
            </div>
        </div>
    </div>
<?php endforeach; ?>