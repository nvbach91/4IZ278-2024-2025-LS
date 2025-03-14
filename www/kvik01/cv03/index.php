<?php 

$isSubmittedForm = !empty($_POST);
$errors = [];

if($isSubmittedForm){

    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);

    $email = htmlspecialchars(trim($_POST['email']));

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        array_push($errors, 'Invalid email');
    }

    if(!preg_match('/^(\+\d{3} )?\d{3} ?\d{3} ?\d{3}$/', $_POST['phone'])){
        array_push($errors, 'Phone has incorrect format');
    }

    if(!filter_var($_POST['avatar'], FILTER_VALIDATE_URL)){
        array_push($errors, 'Invalid avatar URL');
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

<main>
    <div class="container">
        <h1>PHP Form data processing</h1>
        <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">

            <div class="mb-3">
                <label class="form-label">Name*</label>
                <input
                    name="name"
                    class="form-control"
                    value="<?php echo isset($name) ? $name : ''; ?>"
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Gender*</label>
                <select name="gender" class="form-control">
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">E-mail*</label>
                <input
                    name="email"
                    class="form-control"
                    value="<?php echo isset($email) ? $email : ''; ?>"
                >
            </div>
            
            <div class="mb-3">
                <label class="form-label">Phone*</label>
                <input
                    name="phone"
                    class="form-control"
                    value="<?php echo isset($phone) ? $phone : ''; ?>"
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Avatar URL*</label>
                <input
                    name="avatar"
                    class="form-control"
                    value="<?php echo isset($avatar) ? $avatar : ''; ?>"
                >
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>

        </form>
    </div>
</main>
    
</body>
</html>