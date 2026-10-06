<?php
require_once __DIR__ . '/../config/auth.php';
requireRole('admin');
$pageTitle = 'Manage Users'; $base='/ams';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $action=$_POST['action']??'';
    if ($action==='status') { $id=(int)$_POST['id']; $status=$_POST['status']==='inactive'?'inactive':'active'; db()->prepare('UPDATE users SET status=? WHERE id=?')->execute([$status,$id]); flash('success','User status updated.'); redirect('/ams/admin/users.php'); }
    if ($action==='delete') { $id=(int)$_POST['id']; if($id!==(int)$_SESSION['user_id']) { db()->prepare('DELETE FROM users WHERE id=?')->execute([$id]); flash('success','User removed.'); } redirect('/ams/admin/users.php'); }
}
$users=db()->query('SELECT id,student_no,full_name,email,role,course,year_level,section,status,created_at FROM users ORDER BY role, full_name')->fetchAll();
require __DIR__ . '/../includes/header.php'; ?>
<div class="panel"><div class="panel-head"><div><h2>Manage Users</h2><p>Add, deactivate, or remove portal accounts.</p></div><a class="btn btn-primary" href="create_user.php">+ Add user</a></div><div class="table-wrap"><table><thead><tr><th>Name</th><th>ID</th><th>Role</th><th>Course / Section</th><th>Status</th><th>Actions</th></tr></thead><tbody><?php foreach($users as $u): ?><tr><td><strong><?= e($u['full_name']) ?></strong><small class="table-sub"><?= e($u['email']) ?></small></td><td><?= e($u['student_no'] ?: '—') ?></td><td><span class="role-badge <?= e($u['role']) ?>"><?= e(ucfirst($u['role'])) ?></span></td><td><?= e(trim(($u['course'] ?: '') . ' ' . ($u['section'] ?: '')) ?: '—') ?></td><td><span class="badge <?= e($u['status']) ?>"><?= e(ucfirst($u['status'])) ?></span></td><td><form method="post" class="inline-form"><input type="hidden" name="action" value="status"><input type="hidden" name="id" value="<?= $u['id'] ?>"><input type="hidden" name="status" value="<?= $u['status']==='active'?'inactive':'active' ?>"><button class="btn btn-outline btn-xs" type="submit"><?= $u['status']==='active'?'Deactivate':'Activate' ?></button></form><?php if($u['id']!==(int)$_SESSION['user_id']): ?><form method="post" class="inline-form" data-confirm="Delete this user?"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= $u['id'] ?>"><button class="btn btn-danger btn-xs" type="submit">Delete</button></form><?php endif; ?></td></tr><?php endforeach; ?></tbody></table></div></div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
