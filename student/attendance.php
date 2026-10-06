<?php
require_once __DIR__ . '/../config/auth.php';
requireRole('student');
$pageTitle='My Attendance';$base='/ams';$user=currentUser();
$month=$_GET['month']??date('Y-m');$stmt=db()->prepare("SELECT attendance_date,status,time_in,time_out,remarks FROM attendance WHERE student_id=? AND DATE_FORMAT(attendance_date,'%Y-%m')=? ORDER BY attendance_date DESC");$stmt->execute([$user['id'],$month]);$rows=$stmt->fetchAll();
require __DIR__.'/../includes/header.php'; ?>
<div class="panel"><div class="panel-head"><div><h2>My attendance</h2><p>Review your attendance history by month.</p></div><form class="filter-form"><input type="month" name="month" value="<?= e($month) ?>"><button class="btn btn-primary btn-sm">Filter</button></form></div><div class="table-wrap"><table><thead><tr><th>Date</th><th>Time in</th><th>Time out</th><th>Status</th><th>Remarks</th></tr></thead><tbody><?php foreach($rows as $r): ?><tr><td><?= e($r['attendance_date']) ?></td><td><?= e($r['time_in']?:'—') ?></td><td><?= e($r['time_out']?:'—') ?></td><td><span class="badge <?= strtolower($r['status']) ?>"><?= e($r['status']) ?></span></td><td><?= e($r['remarks']?:'—') ?></td></tr><?php endforeach; if(!$rows): ?><tr><td colspan="5" class="empty">No attendance records for <?= e($month) ?>.</td></tr><?php endif; ?></tbody></table></div></div>
<?php require __DIR__.'/../includes/footer.php'; ?>
