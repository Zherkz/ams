<?php
require_once __DIR__ . '/config/auth.php';
if (currentUser()) {
    $u = currentUser();
    header('Location: ' . '/ams/' . $u['role'] . '/dashboard.php');
    exit;
}
$flash = function_exists('getFlash') ? getFlash() : null;
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sign in - Student Attendance System</title>
<link rel="stylesheet" href="assets/css/simple-login.css">
</head>
<body>
<main class="login-page">
  <section class="login-card">
    <div class="school-icon">✓</div>
    <h1>Student Attendance System</h1>
    <p class="subtitle">Please sign in to continue</p>

    <?php if ($flash): ?>
      <div class="alert <?= htmlspecialchars($flash['type'], ENT_QUOTES, 'UTF-8') ?>">
        <?= htmlspecialchars($flash['message'], ENT_QUOTES, 'UTF-8') ?>
      </div>
    <?php endif; ?>

    <form action="login.php" method="post">
      <label for="email">Email</label>
      <input id="email" type="email" name="email" placeholder="Enter your email" required autocomplete="email">

      <label for="password">Password</label>
      <input id="password" type="password" name="password" placeholder="Enter your password" required autocomplete="current-password">

      <button type="submit">Login</button>
    </form>

    <p class="register">Don't have an account? <a href="register.php">Create account</a></p>
    <div class="demo">
      <strong>Demo Account</strong>
      <span>student@ams.local / student123</span>
    </div>
  </section>
</main>
</body>
</html>
