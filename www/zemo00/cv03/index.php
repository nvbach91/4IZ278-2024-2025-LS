<?php require __DIR__ . "/utilities/validation.php"; ?>
<?php include __DIR__ . "/includes/head.html";?>

<?php
if (isset($data['avatar'])){
    $avatar = $data['avatar'];
} else {
    $avatar = '';
}
?>



<h1>Card tournament registration</h1>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <?php foreach($errors as $error): ?>
        <div class="alert-danger"><?php echo $error; ?></div>
    <?php endforeach ?>
    <?php if (isset($successMessage)): ?>
        <div class="success"><?php echo $successMessage;?></div>
    <?php endif; ?>
    <div>
        <label for="username">Name</label>
        <input id="username" name="username"
            value="<?php echo isset($data['username']) ? $data['username'] : ''; ?>"
        >
    </div>
    <div>
        <label for="gender">Gender</label>
        <select name="gender" id="gender">
            <option name="gender" value="m"
                <?php echo isset($data['gender']) && $data['gender'] == 'm' ? ' selected' : ''; ?>>
                Male
            </option>
            <option name="gender" value="f"
                <?php echo isset($data['gender']) && $data['gender'] == 'f' ? ' selected' : ''; ?>>
                Female
            </option>
            <option name="gender" value="n"
                <?php echo isset($data['gender']) && $data['gender'] == 'n' ? ' selected' : ''; ?>>
                Prefer not to say
            </option>
        </select>
    </div>
    <div>
        <label for="email">E-mail</label>
        <input id="email" name="email"
            value="<?php echo isset($data['email']) ? $data['email'] : ''; ?>"
        >
    </div>
    <div>
        <label for="phone">Phone number</label>
        <input id="phone" name="phone"
            value="<?php echo isset($data['phone']) ? $data['phone'] : ''; ?>"
        >
    </div>
    <div>
        <label for="avatar">Avatar</label>
        <img alt="avatar"
            src="<?php echo $avatar; ?>" 
        >
        <input id="avatar" name="avatar" placeholder="https://eso.vse.cz/~zemo00/cv03/esteban.png"
            value="<?php echo $avatar; ?>"
        >
    </div>
    <div>
        <label for="deck">Deck name</label>
        <input id="deck" name="deck"
            value="<?php echo isset($data['deck']) ? $data['deck'] : ''; ?>"
        >
    </div>
    <div>
        <label for="amount">Amount of cards</label>
        <input id="amount" name="amount"
            value="<?php echo isset($data['amount']) ? $data['amount'] : ''; ?>"
        >
    </div>
        <button type="submit">Submit</button>
</form>



<?php include __DIR__ . "/includes/foot.html";?>




<!--


Jako bonus si zkuste odeslat jednoduchou zprávu o úpěšnosti na e-mail z formuláře v případě, že prošla všemi validacemi.


-->
