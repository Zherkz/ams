<?php
declare(strict_types=1);
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/auth.php';
if (currentUser()) redirect('/ams/index.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full = trim($_POST['full_name'] ?? '');
    $studentNo = trim($_POST['student_no'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $course = trim($_POST['course'] ?? '');
    $year = trim($_POST['year_level'] ?? '');
    $section = trim($_POST['section'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if ($password !== $confirm) {
        flash('error', 'Passwords do not match.');
        redirect('/ams/register.php');
    }
    if (strlen($password) < 6) {
        flash('error', 'Password must be at least 6 characters.');
        redirect('/ams/register.php');
    }
    if ($full === '' || $studentNo === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $course === '' || $year === '' || $section === '') {
        flash('error', 'Please complete all required fields.');
        redirect('/ams/register.php');
    }

    $check = db()->prepare('SELECT id FROM users WHERE email = ? OR student_no = ?');
    $check->execute([$email, $studentNo]);
    if ($check->fetch()) {
        flash('error', 'Email or student number is already registered.');
        redirect('/ams/register.php');
    }

    $stmt = db()->prepare('INSERT INTO users (student_no, full_name, email, password, role, course, year_level, section) VALUES (?, ?, ?, ?, "student", ?, ?, ?)');
    $stmt->execute([$studentNo, $full, $email, password_hash($password, PASSWORD_DEFAULT), $course, $year, $section]);
    flash('success', 'Account created successfully. You can now sign in.');
    redirect('/ams/index.php');
}

$authTitle = 'Create account';
$authSubtitle = 'Register as a student and start tracking attendance.';
require __DIR__ . '/includes/auth_card_top.php';
$flash = getFlash();
if ($flash): ?><div class="alert <?= e($flash['type']) ?>"><?= e($flash['message']) ?></div><?php endif; ?>
<form action="register.php" method="post" class="auth-form" id="registerForm">
    <div class="two-col"><div><label>Full name</label><input type="text" name="full_name" required placeholder="Juan Dela Cruz"></div><div><label>Student number</label><input type="text" name="student_no" required placeholder="2026-0001"></div></div>
    <label>Email</label><input type="email" name="email" required placeholder="student@example.com">
    <div class="two-col"><div><label>Course</label><input type="text" name="course" required placeholder="BSIT"></div><div><label>Year level</label><select name="year_level" required><option value="">Select</option><option>1st Year</option><option>2nd Year</option><option>3rd Year</option><option>4th Year</option></select></div></div>
    <label>Section</label><input type="text" name="section" required placeholder="IT-401">
    <div class="two-col"><div><label>Password</label><input type="password" name="password" minlength="6" required></div><div><label>Confirm password</label><input type="password" name="confirm_password" minlength="6" required></div></div>
    <button class="btn btn-primary btn-block" type="submit">Create account <span>→</span></button>
</form>
<div class="auth-links"><span>Already have an account?</span><a href="index.php">Sign in</a></div>
</section></div></body></html>
