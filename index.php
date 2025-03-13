<?php include 'includes/header.php'; ?>

<h1 class="text-3xl font-bold mb-6 text-center">Card Tournament Registration</h1>
<div class="bg-white p-10 rounded-lg shadow-xl w-1/2 text-center flex flex-col items-center">
    <?php
    $errors = [];
    $successMessage = '';
    $name = $gender = $email = $phone = $avatarUrl = $packName = $numberOfCards = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'] ?? '';
        $gender = $_POST['gender'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $avatarUrl = $_POST['avatarurl'] ?? '';
        $packName = $_POST['packname'] ?? '';
        $numberOfCards = $_POST['numberofcards'] ?? '';

        if (empty($name)) {
            $errors['name'] = 'Name is required.';
        }
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Valid email is required.';
        }
        if (empty($phone)) {
            $errors['phone'] = 'Phone number is required.';
        }
        if (!preg_match('/^(\+\d{3})?(\d{3} \d{3} \d{3})$/', $phone)) {
            $errors['phone'] = 'Phone has to be in the correct format';
        }
        if (empty($avatarUrl) || !filter_var($avatarUrl, FILTER_VALIDATE_URL)) {
            $errors['avatarurl'] = 'Valid URL is required';
        }
        if (empty($packName)) {
            $errors['packname'] = 'Pack name is required';
        }
        if (empty($numberOfCards) || !is_numeric($numberOfCards)) {
            $errors['numberofcards'] = 'Number of cards is required and must be a number.';
        }

        if (empty($errors)) {
            $successMessage = 'Registration successful!';
        }
    }
    ?>

    <?php if (!empty($avatarUrl) && empty($errors['avatarurl'])): ?>
        <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-gray-300 mb-6">
            <img src="<?php echo htmlspecialchars($avatarUrl); ?>" alt="Profile Picture" class="w-full h-full object-cover">
        </div>
    <?php else: ?>
        <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-gray-300 mb-6">
            <img src="https://www.pngfind.com/pngs/m/610-6104451_image-placeholder-png-user-profile-placeholder-image-png.png" alt="Profile Picture" class="w-full h-full object-cover">
        </div>
    <?php endif; ?>

    <?php if (!empty($successMessage)): ?>
        <div class="text-green-500 mb-4"><?php echo $successMessage; ?></div>
    <?php endif; ?>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="w-full space-y-2">
        <div>
            <label class="block text-left font-medium">Full Name</label>
            <input type="text" name="name" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?php echo isset($name) ? $name : ''; ?>">
            <?php if (isset($errors['name'])): ?>
                <div class="bg-red-100 text-red-700 p-2 rounded mt-1"><?php echo $errors['name']; ?></div>
            <?php endif; ?>
        </div>

        <div>
            <label class="block text-left font-medium">Gender</label>
            <select name="gender" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="Woman" <?php echo $gender == "Woman" ? 'selected' : ''; ?>>Woman</option>
                <option value="Man" <?php echo $gender == "Man" ? 'selected' : ''; ?>>Man</option>
                <option value="Other" <?php echo $gender == "Other" ? 'selected' : ''; ?>>Other</option>
                <option value="Don't want to disclose" <?php echo $gender == "Don't want to disclose" ? 'selected' : ''; ?>>Don't want to disclose</option>
            </select>
            <?php if (isset($errors['gender'])): ?>
                <div class="bg-red-100 text-red-700 p-2 rounded mt-1"><?php echo $errors['gender']; ?></div>
            <?php endif; ?>
        </div>

        <div>
            <label class="block text-left font-medium">Email</label>
            <input type="email" name="email" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?php echo isset($email) ? $email : ''; ?>">
            <?php if (isset($errors['email'])): ?>
                <div class="bg-red-100 text-red-700 p-2 rounded mt-1"><?php echo $errors['email']; ?></div>
            <?php endif; ?>
        </div>

        <div>
            <label class="block text-left font-medium">Phone</label>
            <input type="text" name="phone" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?php echo isset($phone) ? $phone : ''; ?>">
            <?php if (isset($errors['phone'])): ?>
                <div class="bg-red-100 text-red-700 p-2 rounded mt-1"><?php echo $errors['phone']; ?></div>
            <?php endif; ?>
        </div>

        <div>
            <label class="block text-left font-medium">Avatar URL</label>
            <input type="url" name="avatarurl" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?php echo isset($avatarUrl) ? $avatarUrl : ''; ?>">
            <?php if (isset($errors['avatarurl'])): ?>
                <div class="bg-red-100 text-red-700 p-2 rounded mt-1"><?php echo $errors['avatarurl']; ?></div>
            <?php endif; ?>
            <div class="text-gray-500 text-xs text-left">For ex.: https://eso.vse.cz/~enga03/cv03/doggo.jpeg</div>
        </div>

        <div>
            <label class="block text-left font-medium">Pack Name</label>
            <input type="text" name="packname" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?php echo isset($packName) ? $packName : ''; ?>">
            <?php if (isset($errors['packname'])): ?>
                <div class="bg-red-100 text-red-700 p-2 rounded mt-1"><?php echo $errors['packname']; ?></div>
            <?php endif; ?>
        </div>

        <div>
            <label class="block text-left font-medium">Number of Cards</label>
            <input type="number" name="numberofcards" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?php echo isset($numberOfCards) ? $numberOfCards : ''; ?>">
            <?php if (isset($errors['numberofcards'])): ?>
                <div class="bg-red-100 text-red-700 p-2 rounded mt-1"><?php echo $errors['numberofcards']; ?></div>
            <?php endif; ?>
        </div>

        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition">Submit</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>