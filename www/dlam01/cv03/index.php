<?php require __DIR__ . "/form.php" ?>
<?php include __DIR__ . "/includes/header.php"; ?>
<form action=<?php echo $_SERVER['PHP_SELF'] ?> method="POST" class="form-register">
    <h1>Player registration</h1>
    <div class="row justify-content-center">
        <?php if (isset($errors["fullName"])): ?>
            <div class='alert alert-danger' role='alert'>
                <?php echo $errors["fullName"]; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>

        <div class="mb-3">
            <label class="form-label">Full name*</label>
            <input name="fullName" class="form-control" aria-describedby="fullName"
                value="<?php echo isset($player->fullName) ? $player->fullName : "" ?>">
            <div id="fullName" class="form-text">Enter your full name</div>
        </div>

        <?php if (isset($errors["email"])): ?>
            <div class='alert alert-danger' role='alert'>
                <?php echo $errors["email"]; ?>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label class="form-label">Email address*</label>
            <input name="email" class="form-control" aria-describedby="emailHelp"
                value="<?php echo isset($player->email) ? $player->email : "" ?>">
            <div id="emailHelp" class="form-text">Enter a valid email address e.g. pepa@gmail.com</div>
        </div>

        <?php if (isset($errors["phoneNumber"])): ?>
            <div class='alert alert-danger' role='alert'>
                <?php echo $errors["phoneNumber"]; ?>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label class="form-label">Phone Number*</label>
            <input name="phoneNumber" class="form-control" aria-describedby="phoneNumber"
                value="<?php echo isset($player->phoneNumber) ? $player->phoneNumber : "" ?>">
            <div id="phoneNumber" class="form-text">Enter a valid phone number e.g. +420 123 456 789</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Gender*</label>
            <select class="form-select" aria-label="gender select" name="gender">
                <option value="M" <?php echo isset($player->gender) && $player->gender == "M" ? "selected" : "" ?>>Male</option>
                <option value="F" <?php echo isset($player->gender) && $player->gender == "F" ? "selected" : "" ?>>Female</option>
                <option value="O" <?php echo isset($player->gender) && $player->gender == "O" ? "selected" : "" ?>>Other</option>
            </select>
        </div>

        <?php if (isset($errors["avatar"])): ?>
            <div class='alert alert-danger' role='alert'>
                <?php echo $errors["avatar"]; ?>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label class="form-label">Avatar URL*</label>
            <?php if (isset($player->avatar) && !isset($errors["avatar"])): ?>
                <img src="<?php echo $player->avatar ?>" alt="avatar" class="avatar">
        </div>
    <?php endif; ?>
    <input name="avatar" class="form-control" aria-describedby="avatar"
        value="<?php echo isset($player->avatar) ? $player->avatar : "" ?>">
    <div id="avatar" class="form-text">Enter a valid URL e.g. <a href="https://cdn.myanimelist.net/images/characters/9/179601.jpg"
            target="_blank">https://cdn.myanimelist.net/images/characters/9/179601.jpg</a></div>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
<?php include __DIR__ . "/includes/footer.php"; ?>