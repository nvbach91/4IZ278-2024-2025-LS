<?php
function fetchUsers(){
    $users = [];
    $lines = file(__DIR__ . '/../users.db');
    foreach($lines as $line){
        $fields = explode(';', $line);
        $users[$fields[0]] = [
            'email' => $fields[0],
            'password' => $fields[1],
            'name' => $fields[2]
        ];
    }
    return $users;
}

$users = fetchUsers();
?>

<?php include __DIR__ . '/../includes/header.php' ?>
<?php include __DIR__ . '/../components/navigation.php'?>

<div class="flex justify-center items-center min-h-screen bg-gray-100 pb-20">
    <div class="bg-white p-10 rounded-lg shadow-xl w-3/4 text-center">
        <table class="w-full border-collapse">
            <thead>
                <tr>
                    <th class="border p-2">Email</th>
                    <th class="border p-2">Password</th>
                    <th class="border p-2">Name</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user): ?>
                    <tr>
                        <td class="border p-2"><?php echo htmlspecialchars($user['email']); ?></td>
                        <td class="border p-2"><?php echo htmlspecialchars($user['password']); ?></td>
                        <td class="border p-2"><?php echo htmlspecialchars($user['name']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php' ?>