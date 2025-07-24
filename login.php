<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center" style="background: linear-gradient(135deg, #3f87a6, #ebf8e1);">
  <div class="bg-white shadow-2xl rounded-xl p-10 w-full max-w-md">
    <h2 class="text-2xl font-bold text-center text-blue-700 mb-6">Login Sistem</h2>
    
    <?php if (!empty($_SESSION['error'])): ?>
      <div class="bg-red-100 text-red-700 p-2 rounded mb-4"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form action="proses_login.php" method="POST" class="space-y-4">
      <div>
        <label class="block text-gray-700 font-medium">Username</label>
        <input type="text" name="username" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>
      <div>
        <label class="block text-gray-700 font-medium">Password</label>
        <input type="password" name="password" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>
      <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold">Login</button>
    </form>
  </div>
</body>
</html>