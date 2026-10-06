<?php
require_once __DIR__ . '/../config/auth.php';
$user = currentUser();
$pageTitle = $pageTitle ?? APP_NAME;
$base = $base ?? '/ams';
$flash = getFlash();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?> · AMS</title>
    <link rel="stylesheet" href="<?= $base ?>/assets/css/style.css">
</head>
<body class="app-body">
<div class="app-shell">
    <aside class="sidebar" id="sidebar">
        <div class="brand"><span class="brand-mark">✣</span><div><strong>AMS</strong><small>Attendance Management</small></div></div>
        <?php if ($user): ?>
            <div class="user-chip"><div class="avatar"><?= e(strtoupper(substr($user['full_name'], 0, 1))) ?></div><div><strong><?= e($user['full_name']) ?></strong><small><?= e(ucfirst($user['role'])) ?></small></div></div>
            <nav class="nav-list">
                <?php if ($user['role'] === 'admin'): ?>
                    <a class="nav-link" href="<?= $base ?>/admin/dashboard.php">▦ <span>Dashboard</span></a>
                    <a class="nav-link" href="<?= $base ?>/admin/users.php">♙ <span>Manage Users</span></a>
                    <a class="nav-link" href="<?= $base ?>/admin/attendance.php">✓ <span>Attendance</span></a>
                    <a class="nav-link" href="<?= $base ?>/admin/reports.php">▤ <span>Reports</span></a>
                <?php elseif ($user['role'] === 'teacher'): ?>
                    <a class="nav-link" href="<?= $base ?>/teacher/dashboard.php">▦ <span>Dashboard</span></a>
                    <a class="nav-link" href="<?= $base ?>/teacher/attendance.php">✓ <span>Record Attendance</span></a>
                    <a class="nav-link" href="<?= $base ?>/teacher/view_attendance.php">▤ <span>View Attendance</span></a>
                    <a class="nav-link" href="<?= $base ?>/teacher/profile.php">♙ <span>My Profile</span></a>
                <?php else: ?>
                    <a class="nav-link" href="<?= $base ?>/student/dashboard.php">▦ <span>Dashboard</span></a>
                    <a class="nav-link" href="<?= $base ?>/student/profile.php">♙ <span>My Profile</span></a>
                    <a class="nav-link" href="<?= $base ?>/student/attendance.php">✓ <span>My Attendance</span></a>
                <?php endif; ?>
            </nav>
            <div class="sidebar-bottom"><a class="nav-link logout-link" href="<?= $base ?>/logout.php">↪ <span>Log out</span></a></div>
        <?php endif; ?>
    </aside>
    <main class="main-content">
        <header class="topbar">
            <button class="mobile-menu" id="mobileMenu">☰</button>
            <div><span class="eyebrow">ATTENDANCE MANAGEMENT SYSTEM</span><h1><?= e($pageTitle) ?></h1></div>
            <?php if ($user): ?><div class="top-user"><span><?= e($user['full_name']) ?></span><span class="top-role"><?= e(ucfirst($user['role'])) ?></span></div><?php endif; ?>
        </header>
        <?php if ($flash): ?><div class="alert <?= e($flash['type']) ?>"><?= e($flash['message']) ?></div><?php endif; ?>
