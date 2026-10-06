<?php
require_once __DIR__ . '/../config/auth.php';
requireRole('admin');
$pageTitle='Add User'; $base='/ams';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $full=trim($_POST['full_name']??'');$email=trim($_POST['email']??'');$studentNo=trim($_POST['student_no']??'');$role=$_POST['role']??'student';$course=trim($_POST['course']??'');$year=trim($_POST['year_level']??'');$section=trim($_POST['section']??'');$password=$_POST['password']??'';
    if(!in_array($role,['admin','teacher','student'],true))$role='student';
    $check=db()->prepare('SELECT id FROM users WHERE email=? OR student_no=?');$check->execute([$email,$studentNo]);
    if($check->fetch()){flash('error','Email or ID already exists.');redirect('/ams/admin/create_user.php');}
    db()->prepare('INSERT INTO users(student_no,full_name,email,password,role,course,year_level,section) VALUES(?,?,?,?,?,?,?,?)')->execute([$studentNo,$full,$email,password_hash($password,PASSWORD_DEFAULT),$role,$course,$year,$section]);
    flash('success','User created successfully.');redirect('/ams/admin/users.php');
}
require __DIR__.'/../includes/header.php'; ?>
<div class="panel form-panel"><h2>Add User</h2><p>Create an admin, teacher, or student account.</p><form method="post" class="dashboard-form"><div class="two-col"><div><label>Full name</label><input name="full_name" required></div><div><label>Email</label><input type="email" name="email" required></div></div><div class="two-col"><div><label>Student / Employee ID</label><input name="student_no" required></div><div><label>Role</label><select name="role"><option value="student">Student</option><option value="teacher">Teacher</option><option value="admin">Admin</option></select></div></div><div class="two-col"><div><label>Course</label><input name="course"></div><div><label>Year level</label><input name="year_level"></div></div><div class="two-col"><div><label>Section</label><input name="section"></div><div><label>Temporary password</label><input type="password" name="password" minlength="6" required></div></div><button class="btn btn-primary" type="submit">Create user</button></form></div>
<?php require __DIR__.'/../includes/footer.php'; ?>
