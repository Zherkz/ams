<?php
require_once __DIR__ . '/../config/auth.php';
requireRole('teacher');
$pageTitle='Record Attendance';$base='/ams';
$date=$_POST['attendance_date']??$_GET['date']??date('Y-m-d');
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['save_attendance'])){
    $pdo=db();$pdo->beginTransaction();
    try{
        $up=$pdo->prepare('INSERT INTO attendance(student_id,attendance_date,status,time_in,remarks,recorded_by) VALUES(?,?,?,?,?,?) ON DUPLICATE KEY UPDATE status=VALUES(status),time_in=VALUES(time_in),remarks=VALUES(remarks),recorded_by=VALUES(recorded_by)');
        foreach(($_POST['status']??[]) as $sid=>$st){if(!in_array($st,['Present','Late','Absent'],true))continue;$time=($st==='Present'||$st==='Late')?date('H:i:s'):null;$remark=trim($_POST['remarks'][$sid]??'');$up->execute([(int)$sid,$date,$st,$time,$remark,(int)$_SESSION['user_id']]);}
        $pdo->commit();flash('success','Attendance saved for '. $date .'.');redirect('/ams/teacher/attendance.php?date='.urlencode($date));
    }catch(Throwable $e){$pdo->rollBack();flash('error','Unable to save attendance.');}
}
$students=db()->query("SELECT id,student_no,full_name,course,section FROM users WHERE role='student' AND status='active' ORDER BY full_name")->fetchAll();$existing=db()->prepare('SELECT student_id,status,remarks FROM attendance WHERE attendance_date=?');$existing->execute([$date]);$map=[];foreach($existing as $r)$map[$r['student_id']]=$r;
require __DIR__.'/../includes/header.php'; ?>
<div class="panel"><div class="panel-head"><div><h2>Record attendance</h2><p>Mark today's status for each active student.</p></div><form class="filter-form" method="get"><input type="date" name="date" value="<?= e($date) ?>"><button class="btn btn-outline btn-sm">Load</button></form></div><form method="post"><input type="hidden" name="attendance_date" value="<?= e($date) ?>"><div class="table-wrap"><table><thead><tr><th>Student</th><th>Course / Section</th><th>Status</th><th>Remarks</th></tr></thead><tbody><?php foreach($students as $s): $cur=$map[$s['id']]['status']??'Present'; ?><tr><td><strong><?= e($s['full_name']) ?></strong><small class="table-sub"><?= e($s['student_no']) ?></small></td><td><?= e(trim($s['course'].' '.$s['section'])) ?></td><td><select name="status[<?= $s['id'] ?>]"><option <?= $cur==='Present'?'selected':'' ?>>Present</option><option <?= $cur==='Late'?'selected':'' ?>>Late</option><option <?= $cur==='Absent'?'selected':'' ?>>Absent</option></select></td><td><input name="remarks[<?= $s['id'] ?>]" value="<?= e($map[$s['id']]['remarks']??'') ?>" placeholder="Optional"></td></tr><?php endforeach; ?></tbody></table></div><div class="form-actions"><button class="btn btn-primary" name="save_attendance" type="submit">Save attendance</button></div></form></div>
<?php require __DIR__.'/../includes/footer.php'; ?>
