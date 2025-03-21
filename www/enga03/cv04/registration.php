<?php require __DIR__ . '/scripts/formProcessing.php'?>

<?php include __DIR__ . '/includes/header.php' ?>
<?php include __DIR__ . '/components/navigation.php' ?>

<div class="flex justify-center items-center min-h-screen bg-gray-100 pb-20">
    <div class="bg-white p-10 rounded-lg shadow-xl w-1/2 text-center flex flex-col items-center">
        <?php if (!empty($successMessage)): ?>
            <div class="text-green-500 mb-4"><?php echo $successMessage; ?></div>
        <?php endif; ?>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="w-full space-y-2">
            <div>
                <label class="block text-left font-medium">Full Name</label>
                <input type="text" name="name" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?php echo htmlspecialchars($name); ?>">
                <?php if (isset($errors['name'])): ?>
                    <div class="bg-red-100 text-red-700 p-2 rounded mt-1"><?php echo $errors['name']; ?></div>
                <?php endif; ?>
            </div>

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

            <div>
                <label class="block text-left font-medium">Confirm Password</label>
                <input type="password" name="confirm_password" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                <?php if (isset($errors['confirm_password'])): ?>
                    <div class="bg-red-100 text-red-700 p-2 rounded mt-1"><?php echo $errors['confirm_password']; ?></div>
                <?php endif; ?>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition">Submit</button>
        </form>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php' ?>