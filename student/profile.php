<?php
require_once __DIR__ . '/../config/auth.php';
requireRole('student');
$pageTitle='My Profile';$base='/ams';$user=currentUser();
if($_SERVER['REQUEST_METHOD']==='POST'){
    $full=trim($_POST['full_name']??'');$email=trim($_POST['email']??'');$course=trim($_POST['course']??'');$year=trim($_POST['year_level']??'');$section=trim($_POST['section']??'');
    $check=db()->prepare('SELECT id FROM users WHERE email=? AND id<>?');$check->execute([$email,$user['id']]);
    if($check->fetch()){flash('error','That email is already in use.');redirect('/ams/student/profile.php');}
    db()->prepare('UPDATE users SET full_name=?,email=?,course=?,year_level=?,section=? WHERE id=?')->execute([$full,$email,$course,$year,$section,$user['id']]);flash('success','Profile updated.');redirect('/ams/student/profile.php');
}
require __DIR__.'/../includes/header.php'; ?>
<div class="profile-grid"><section class="profile-card"><div class="profile-avatar"><?= e(strtoupper(substr($user['full_name'],0,1))) ?></div><h2><?= e($user['full_name']) ?></h2><p><?= e($user['email']) ?></p><span class="role-badge student">Student</span></section><section class="panel form-panel"><h2>My profile</h2><p>Update the information shown on your student account.</p><form method="post" class="dashboard-form"><div class="two-col"><div><label>Full name</label><input name="full_name" value="<?= e($user['full_name']) ?>" required></div><div><label>Email</label><input type="email" name="email" value="<?= e($user['email']) ?>" required></div></div><div class="two-col"><div><label>Student number</label><input value="<?= e($user['student_no']) ?>" disabled></div><div><label>Course</label><input name="course" value="<?= e($user['course']) ?>"></div></div><div class="two-col"><div><label>Year level</label><input name="year_level" value="<?= e($user['year_level']) ?>"></div><div><label>Section</label><input name="section" value="<?= e($user['section']) ?>"></div></div><button class="btn btn-primary" type="submit">Save changes</button></form></section></div>
<?php require __DIR__.'/../includes/footer.php'; ?>
