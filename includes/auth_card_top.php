<?php
require_once __DIR__ . '/../config/config.php';
$authTitle = $authTitle ?? 'Welcome back';
$authSubtitle = $authSubtitle ?? 'Sign in to continue';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($authTitle) ?> · AMS</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="auth-body">
<div class="auth-bg-orb orb-one"></div><div class="auth-bg-orb orb-two"></div>
<div class="auth-layout">
    <section class="auth-branding">
        <div class="brand"><span class="brand-mark">✣</span><div><strong>AMS</strong><small>Attendance Management System</small></div></div>
        <h1>Track attendance.<br><span>Stay on course.</span></h1>
        <p>A clean portal for administrators, teachers, and students to manage attendance records in one place.</p>
        <div class="feature-row"><span>✓ Secure access</span><span>✓ Live records</span><span>✓ Reports</span></div>
    </section>
    <section class="auth-card">
        <div class="auth-heading"><span class="eyebrow">AMS PORTAL</span><h2><?= e($authTitle) ?></h2><p><?= e($authSubtitle) ?></p></div>
