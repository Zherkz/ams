<?php
declare(strict_types=1);
require_once __DIR__ . '/config/auth.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('/ams/index.php');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$stmt = db()->prepare('SELECT * FROM users WHERE email = ? AND status = "active" LIMIT 1');
$stmt->execute([$email]);
$user = $stmt->fetch();
if (!$user || !password_verify($password, $user['password'])) {
    flash('error', 'Invalid email or password.');
    redirect('/ams/index.php');
}
$_SESSION['pending_user_id'] = (int)$user['id'];
$_SESSION['pending_otp'] = OTP_DEMO_CODE;
$_SESSION['otp_expires'] = time() + 300;
redirect('/ams/verify.php');
