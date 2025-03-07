<?php foreach ($people as $person): ?>
    <div id="businessCard">
        <div id="logoContainer">
            <img id="logo" src="<?php echo "./assets/" . $person->logoPath; ?>" alt="">
        </div>
        <div id="infoContainer">
            <div id="nameAndBasicInfo">
                <h1><?php echo $person->getFullName(); ?></h1>
                <div class="labelGroup">
                    <span class="label">company</span>
                    <span id="companyName"><?php echo $person->companyName; ?></span>
                </div>
                <div class="labelGroup">
                    <span class="label">age</span>
                    <span><?php echo $person->getAge(); ?></span>
                </div>
            </div>
            <div id="details">
                <div id="jobs" class="labelGroup">
                    <span class="label">current jobs</span>
                    <?php foreach ($person->jobs as $job): ?>
                        <span><?php echo $job; ?></span>
                    <?php endforeach; ?>
                </div>
                <div id="address" class="labelGroup">
                    <span class="label">address</span>
                    <span><?php echo $person->getAddress(); ?></span>
                </div>
                <div id="contactInfo" class="labelGroup">
                    <span class="label">contact</span>
                    <span><?php echo $person->phoneNumber; ?></span>
                    <span><?php echo $person->email; ?></span>
                    <a href="<?php echo $person->webpage; ?>">my webpage</a>
                </div>
            </div>
            <div class="labelGroup">
                <span class="label">status</span>
                <p><?php echo $person->isLookingForJob(); ?></p>
            </div>
        </div>
    </div>
<?php endforeach; ?>