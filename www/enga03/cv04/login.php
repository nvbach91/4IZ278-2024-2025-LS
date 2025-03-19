<?php
$errors = [];
$successMessage = '';
$email = $_GET['email'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // validation
    if (empty($email)) {
        $errors['email'] = 'Email is required.';
    }
    if (empty($password)) {
        $errors['password'] = 'Password is required.';
    }

    if (empty($errors)) {
        // authentication
        $result = authenticate($email, $password);
        if ($result === true) {
            $successMessage = 'Login successful!';
        } elseif ($result === 'User not found') {
            $errors['email'] = 'User does not exist.';
        } elseif ($result === 'Incorrect password') {
            $errors['password'] = 'Incorrect password.';
        }
    }
}

function fetchUser($email) {
    $users = fetchUsers();
    return $users[$email] ?? null;
}

function fetchUsers() {
    $users = [];
    $lines = file(__DIR__ . '/users.db');
    foreach ($lines as $line) {
        $fields = explode(';', $line);
        $users[$fields[0]] = [
            'email' => $fields[0],
            'password' => $fields[1],
            'name' => $fields[2]
        ];
    }
    return $users;
}

function authenticate($email, $password) {
    $user = fetchUser($email);
    if (!$user) {
        return 'User not found';
    }
    if ($user['password'] !== $password) {
        return 'Incorrect password';
    }
    return true;
}
?>

<?php include __DIR__ . '/includes/header.php' ?>
<?php include __DIR__ . '/components/navigation.php' ?>

<div class="flex justify-center items-center min-h-screen bg-gray-100 pb-20">
    <div class="bg-white p-10 rounded-lg shadow-xl w-1/2 text-center flex flex-col items-center">
        <?php if (isset($_GET['registered']) && $_GET['registered'] === 'true'): ?>
            <div class="text-green-500 mb-4">Registration successful! Please log in.</div>
        <?php endif; ?>

        <?php if (!empty($successMessage)): ?>
            <div class="text-green-500 mb-4"><?php echo $successMessage; ?></div>
        <?php endif; ?>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="w-full space-y-2">
            <div>
                <label class="block text-left font-medium">Email</label>
                <input type="email" name="email" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?php echo htmlspecialchars($email); ?>">
                <?php if (isset($errors['email'])): ?>
                    <div class="bg-red-100 text-red-700 p-2 rounded mt-1"><?php echo $errors['email']; ?></div>
                <?php endif; ?>
            </div>

            <div>
                <label class="block text-left font-medium">Password</label>
                <input type="password" name="password" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                <?php if (isset($errors['password'])): ?>
                    <div class="bg-red-100 text-red-700 p-2 rounded mt-1"><?php echo $errors['password']; ?></div>
                <?php endif; ?>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition">Login</button>
        </form>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php' ?>