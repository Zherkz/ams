<?php
declare(strict_types=1);
require_once __DIR__ . '/config/auth.php';

if (empty($_SESSION['pending_user_id'])) {
    header('Location: /ams/index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otp = trim($_POST['otp'] ?? '');

    if ($otp !== OTP_DEMO_CODE || time() > (int)($_SESSION['otp_expires'] ?? 0)) {
        flash('error', 'Invalid or expired verification code.');
        header('Location: /ams/verify.php');
        exit;
    }

    loginUser((int)$_SESSION['pending_user_id']);
    unset($_SESSION['pending_user_id'], $_SESSION['pending_otp'], $_SESSION['otp_expires']);

    $u = currentUser();
    header('Location: /ams/' . $u['role'] . '/dashboard.php');
    exit;
}

$flash = getFlash();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verification - Student Attendance System</title>
    <link rel="stylesheet" href="assets/css/simple-otp.css">
</head>
<body>
<main class="otp-page">
    <section class="otp-card">
        <div class="school-icon">✓</div>
        <h1>Verification Code</h1>
        <p class="subtitle">Enter the 6-digit code to continue</p>

        <?php if ($flash): ?>
            <div class="alert <?= htmlspecialchars($flash['type'], ENT_QUOTES, 'UTF-8') ?>">
                <?= htmlspecialchars($flash['message'], ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <form action="verify.php" method="post">
            <label for="otp">Verification code</label>
            <input id="otp" class="otp-input" type="text" name="otp" maxlength="6" inputmode="numeric" pattern="[0-9]{6}" placeholder="Enter code" required autofocus autocomplete="one-time-code">
            <button type="submit">Verify</button>
        </form>

        <div class="demo">
            <strong>Demo code</strong>
            <span>123456</span>
        </div>

        <p class="back"><a href="index.php">← Back to login</a></p>
    </section>
</main>
<script>
document.getElementById('otp').addEventListener('input', function () {
    this.value = this.value.replace(/\D/g, '').slice(0, 6);
});
</script>
</body>
</html>
