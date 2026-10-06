<?php
require_once __DIR__ . '/../config/auth.php';
requireRole('teacher');
$pageTitle='View Attendance';$base='/ams';$date=$_GET['date']??date('Y-m-d');
$stmt=db()->prepare('SELECT a.*,u.full_name,u.student_no,u.course,u.section FROM attendance a JOIN users u ON u.id=a.student_id WHERE a.attendance_date=? ORDER BY u.full_name');$stmt->execute([$date]);$rows=$stmt->fetchAll();
require __DIR__.'/../includes/header.php'; ?>
<div class="panel"><div class="panel-head"><div><h2>View attendance</h2><p>Attendance records for the selected date.</p></div><form class="filter-form"><input type="date" name="date" value="<?= e($date) ?>"><button class="btn btn-primary btn-sm">View</button></form></div><div class="table-wrap"><table><thead><tr><th>Student</th><th>Course</th><th>Time in</th><th>Status</th><th>Remarks</th></tr></thead><tbody><?php foreach($rows as $r): ?><tr><td><strong><?= e($r['full_name']) ?></strong><small class="table-sub"><?= e($r['student_no']) ?></small></td><td><?= e(trim($r['course'].' '.$r['section'])) ?></td><td><?= e($r['time_in']?:'—') ?></td><td><span class="badge <?= strtolower($r['status']) ?>"><?= e($r['status']) ?></span></td><td><?= e($r['remarks']?:'—') ?></td></tr><?php endforeach; if(!$rows): ?><tr><td colspan="5" class="empty">No records for this date.</td></tr><?php endif; ?></tbody></table></div></div>
<?php require __DIR__.'/../includes/footer.php'; ?>
