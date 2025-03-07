<?php 

require './utils.php';

if($isSubmittedForm) {
  //nacteni hodnot z formulare
  $email = htmlspecialchars(trim($_POST['email']));
  $password = htmlspecialchars(trim($_POST['password']));
  $phone = htmlspecialchars(trim($_POST['phone']));
  $avatar = htmlspecialchars(trim($_POST['avatar']));
  $name = htmlspecialchars(trim($_POST['name']));
  $gender = $_POST['gender'] ?? '';
  $deckname = htmlspecialchars(trim($_POST['deckname']));
  $numberofcards = htmlspecialchars(trim($_POST['numberofcards']));
   
  //test validity
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Email is not valid';
  }
  if(!preg_match('/^(\+\d{3} ?)?(\d{3} ?){3}$/', $phone)) {
    $errors['phone'] = 'Phone is not valid';
  }
  if(!filter_var($avatar, FILTER_VALIDATE_URL)) {
    $errors['avatar'] = 'Avatar URL is not valid';
  }
  if(!preg_match('/[a-zA-Z ]+$/', $name)) {
    $errors['name'] = 'Name is not valid';
  }
  if(!preg_match('/^[a-zA-Z ]+$/', $deckname)) {
    $errors['deckname'] = 'Deckname is not valid';
  }
  if(!preg_match('/^\d+$/', $numberofcards)) {
    $errors['numberofcards'] = 'Number of cards is not valid';
  }

  //test spravnosti
  if($email != $correctemail && filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Email is not correct';
  }
  if($password != $correctpassword) {
    $errors['password'] = 'Password is not correct';
  }
  if($phone != $correctphone) {
    $errors['phone'] = 'Phone is not correct';
  }
  if($avatar != $correctavatar) {
    $errors['avatar'] = 'Avatar is not correct';
  }
  if($name != $correctname) {
    $errors['name'] = 'Name is not correct';
  }
  if($gender != $correctgender) {
    $errors['gender'] = 'Gender is not correct';
  }
  if($deckname != $correctdeckname) {
    $errors['deckname'] = 'Deckname is not correct';
  }
  if($numberofcards != $correctnumberofcards) {
    $errors['numberofcards'] = 'Number of cards is not correct';
  }
  
  //test prazdnoty
  if(empty($email)) {
    $errors['email'] = 'Please fill in the email';
  }
  if(empty($password)) {
    $errors['password'] = 'Please fill in the password';
  }
  if(empty($phone)) {
    $errors['phone'] = 'Please fill in the phone';
  }
  if(empty($avatar)) {
    $errors['avatar'] = 'Please fill in the avatar';
  }
  if(empty($name)) {
    $errors['name'] = 'Please fill in the name';
  }
  if(empty($deckname)) {
    $errors['deckname'] = 'Please fill in the deckname';
  }
  if(empty($numberofcards)) {
    $errors['numberofcards'] = 'Please fill in the number of cards';
  }

  //test gender
  if (empty($gender)) {
    $errors['gender'] = 'Please select a gender';
}
  //vse je ok
  if(empty($errors) && $email == $correctemail && $password == $correctpassword && $phone == $correctphone && $avatar == $correctavatar && $name == $correctname && $gender == $correctgender && $deckname == $correctdeckname && $numberofcards == $correctnumberofcards) {
    header('Location: ./profile.php');
    exit;
  }
}
?>

<?php include './includes/header.php'; ?>
<body>
    <h1>Pepe Forms</h1>
    <form method="POST" action="<?php echo  $_SERVER['PHP_SELF'] ?>">
    <div class="form-group">
      <div class="mb3">
        <label for="exampleInputName">Name</label>
        <input 
            name = "name"
            class="form-control"
            placeholder="Name"
            value="<?php echo isset($name) ? $name : ''; ?>">
            <small>Correct:<br>Pepe The Frog</small>
      </div>
      <?php if(isset($errors['name'])) : ?>
        <div class="alert alert-danger"><?php echo $errors['name']; ?></div>
      <?php endif; ?>
      <div class="mb3">
            <label for="exampleInputPassword">Password</label>
            <input 
                name = "password"
                class="form-control"
                placeholder="Password"
                value="<?php echo isset($password) ? $password : ''; ?>">
                <small>Correct:<br>pepe</small>
        </div>
        <?php if(isset($errors['password'])) : ?>
          <div class="alert alert-danger"><?php echo $errors['password']; ?></div>
        <?php endif; ?>
    </div>
    <div class="form-group2">
      <div class="mb3">
            <label for="exampleInputPhone">Phone</label>
            <input 
                name = "phone"
                class="form-control"
                placeholder="Phone"
                value="<?php echo isset($phone) ? $phone : ''; ?>">
                <small>Correct:<br>+420 123 456 789</small>
        </div>
        <?php if(isset($errors['phone'])) : ?>
          <div class="alert alert-danger"><?php echo $errors['phone']; ?></div>
        <?php endif; ?>

      <div class="mb3">
            <label for="exampleInputEmail">Email address</label>
            <input 
                name = "email"
                class="form-control"
                placeholder="Enter email"
                value="<?php echo isset($email) ? $email : ''; ?>">
                <small>Correct:<br>pepe@pepe.tv</small>
      </div>
      <?php if(isset($errors['email'])) : ?>
        <div class="alert alert-danger"><?php echo $errors['email']; ?></div>
      <?php endif; ?>
    </div>
    <div class="form-group3">
      <div class="mb3">
          <label>Gender</label>
          <select name="gender" class="form-control">
          <option value="male" <?php echo (isset($gender) && $gender === 'male') ? 'selected' : ''; ?>>Male</option>
          <option value="female" <?php echo (isset($gender) && $gender === 'female') ? 'selected' : ''; ?>>Female</option>
          <option value="pepe" <?php echo (isset($gender) && $gender === 'pepe') ? 'selected' : ''; ?>>Pepe</option>
          </select>
          <small>Correct:<br>Pepe</small>
      </div>
      <?php if(isset($errors['gender'])) : ?>
          <div class="alert alert-danger"><?php echo $errors['gender']; ?></div>
      <?php endif; ?>

        <div class="mb3">
          <label for="exampleInputAvatar">Avatar</label>
          <input 
              name = "avatar"
              class="form-control"
              placeholder="Avatar"
              value="<?php echo isset($avatar) ? $avatar : ''; ?>">
              <small>Correct:<br>https://eso.vse.cz/~schd22/cv03/Pepe.png</small>
        </div>
        <?php if(isset($errors['avatar'])) : ?>
          <div class="alert alert-danger"><?php echo $errors['avatar']; ?></div>
        <?php endif; ?>

        <div class="mb3">
          <label for="exampleInputDeckname">Deckname</label>
          <input 
              name = "deckname"
              class="form-control"
              placeholder="Deckname"
              value="<?php echo isset($deckname) ? $deckname : ''; ?>">
              <small>Correct:<br>Control Shaman</small>
        </div>
        <?php if(isset($errors['deckname'])) : ?>
          <div class="alert alert-danger"><?php echo $errors['deckname']; ?></div>
        <?php endif; ?>

        <div class="mb3">
          <label for="exampleInputNumberofcards">Number of cards</label>
          <input 
              name = "numberofcards"
              class="form-control"
              placeholder="Number of cards"
              value="<?php echo isset($numberofcards) ? $numberofcards : ''; ?>">
              <small>Correct:<br>30</small>
        </div>
        <?php if(isset($errors['numberofcards'])) : ?>
          <div class="alert alert-danger"><?php echo $errors['numberofcards']; ?></div>
        <?php endif; ?>

        <div class="button">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    </form>

<?php include './includes/footer.php'; ?>