<?php
require_once __DIR__ . '/../config/auth.php';
requireRole('teacher');
$pageTitle='My Profile';$base='/ams';$user=currentUser();
require __DIR__.'/../includes/header.php'; ?>
<div class="profile-grid"><section class="profile-card"><div class="profile-avatar"><?= e(strtoupper(substr($user['full_name'],0,1))) ?></div><h2><?= e($user['full_name']) ?></h2><p><?= e($user['email']) ?></p><span class="role-badge teacher">Teacher</span></section><section class="panel"><h2>Account information</h2><div class="info-grid"><div><small>Employee ID</small><strong><?= e($user['student_no']?:'—') ?></strong></div><div><small>Course</small><strong><?= e($user['course']?:'—') ?></strong></div><div><small>Section</small><strong><?= e($user['section']?:'—') ?></strong></div><div><small>Year level</small><strong><?= e($user['year_level']?:'—') ?></strong></div></div></section></div>
<?php require __DIR__.'/../includes/footer.php'; ?>
