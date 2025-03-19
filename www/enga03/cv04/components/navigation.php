<?php
$baseDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
$baseUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $baseDir;
$baseUrl = rtrim($baseUrl, '/admin');
?>
<nav class="bg-gray-800">
  <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
    <div class="relative flex h-16 items-center justify-between">
      <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
        <div class="hidden sm:ml-6 sm:block">
          <div class="flex space-x-4">
            <a href="<?php echo $baseUrl; ?>/registration.php" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Registration</a>
            <a href="<?php echo $baseUrl; ?>/login.php" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Login</a>
            <a href="<?php echo $baseUrl; ?>/admin/users.php" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Users</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>
