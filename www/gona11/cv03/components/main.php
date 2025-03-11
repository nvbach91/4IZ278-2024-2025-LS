<?php require __DIR__ . '/../classes/script.php'?>

    <div class="flex">
    <h1>Cat card showdown registration</h1>
    <form class="form-signup" method="POST" action="<?php echo  $_SERVER['PHP_SELF'] ?>">

        <?php if(isset($errors['success'])) :?>
            <div class="alert alert-success mt-3"><?php echo $errors['success'];?></div>
        <?php endif; ?>

        <?php if(isset($errors['name'])) : ?>
            <div class="alert alert-danger mt-3"><?php echo $errors['name'];?></div>
        <?php endif; ?>

        <div class="form-group mb-3">
            <label>Name</label>
            <input 
                class="form-control"
                name="name"
                value="<?php echo isset($name) ? $name : ''; ?>">
        </div>

        <?php if(isset($errors['gender'])) : ?>
            <div class="alert alert-danger mt-3"><?php echo $errors['gender'];?></div>
        <?php endif; ?>

        <div class="form-group mb-3">
            <label>Gender</label>
            <select class="form-select" name="gender">
                <option value="Male" <?php echo isset($gender) && $gender == 'Male' ? ' selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo isset($gender) && $gender == 'Female' ? ' selected' : ''; ?>>Female</option>
                <option value="Cat" <?php echo isset($gender) && $gender == 'Cat' ? ' selected' : ''; ?>>Cat</option>
            </select>
            <div class="form-text">Choose an option</div>
        </div>

        <?php if(isset($errors['email'])) : ?>
            <div class="alert alert-danger mt-3"><?php echo $errors['email'];?></div>
        <?php endif; ?>

        <div class="form-group mb-3">
            <label>Email</label>
            <input 
                class="form-control"
                name="email"
                value="<?php echo isset($email) ? $email : ''; ?>">
        </div>

        <?php if(isset($errors['phone'])) : ?>
            <div class="alert alert-danger mt-3"><?php echo $errors['phone'];?></div>
        <?php endif; ?>

        <div class="form-group mb-3">
            <label>Phone</label>
            <input class="form-control" name="phone" value="<?php echo isset($phone) ? $phone : ''; ?>">
            <div id="passwordHelpBlock" class="form-text">Example: +420678547474</div>
        </div>

        <?php if(isset($errors['avatar'])) : ?>
            <div class="alert alert-danger mt-3"><?php echo $errors['avatar'];?></div>
        <?php endif; ?>

        <div class="form-group mb-3">
            <label>Avatar URL</label>
            <?php if(!empty($avatar))?>
                <img src="<?php echo $avatar; ?>" alt="">
            <?php ?>
            <input class="form-control" name="avatar" value="<?php echo isset($avatar) ? $avatar : ''; ?>">
            <div class="form-text">Example: https://eso.vse.cz/~gona11/cv03/resources/profile_cat.jpg</div>
        </div>

        <?php if(isset($errors['deck_name'])) : ?>
            <div class="alert alert-danger mt-3"><?php echo $errors['deck_name'];?></div>
        <?php endif; ?>

        <div class="form-group mb-3">
            <label>Deck name</label>
            <input class="form-control" name="deck_name" value="<?php echo isset($deck_name) ? $deck_name : ''; ?>">
        </div>

        <?php if(isset($errors['card_count'])) : ?>
            <div class="alert alert-danger mt-3"><?php echo $errors['card_count'];?></div>
        <?php endif; ?>

        <div class="form-group mb-3">
            <label>No. of cards</label>
            <input class="form-control" name="card_count" value="<?php echo isset($card_count) ? $card_count : ''; ?>">
            <div id="passwordHelpBlock" class="form-text">Allowed deck size: 12 - 80 cards</div>
        </div>

        <button class="btn btn-primary mt-3" type="submit">Register</button>
    </form>
    </div>
