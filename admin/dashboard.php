<?php
require_once __DIR__ . '/../config/auth.php';
requireRole('admin');
$pageTitle = 'Dashboard'; $base = '/ams';
$totalUsers = (int)db()->query('SELECT COUNT(*) FROM users')->fetchColumn();
$totalStudents = (int)db()->query("SELECT COUNT(*) FROM users WHERE role='student'")->fetchColumn();
$todayPresent = (int)db()->query("SELECT COUNT(*) FROM attendance WHERE attendance_date = CURDATE() AND status='Present'")->fetchColumn();
$todayRecords = (int)db()->query('SELECT COUNT(*) FROM attendance WHERE attendance_date = CURDATE()')->fetchColumn();
$rate = $todayRecords ? round($todayPresent / $todayRecords * 100) : 0;
$recent = db()->query('SELECT a.attendance_date, u.full_name, a.status, a.time_in FROM attendance a JOIN users u ON u.id=a.student_id ORDER BY a.id DESC LIMIT 6')->fetchAll();
require __DIR__ . '/../includes/header.php'; ?>
<section class="stats-grid"><div class="stat-card"><span>Total Users</span><strong><?= $totalUsers ?></strong><small>Registered accounts</small></div><div class="stat-card"><span>Students</span><strong><?= $totalStudents ?></strong><small>Active student accounts</small></div><div class="stat-card"><span>Present Today</span><strong><?= $todayPresent ?></strong><small>Students marked present</small></div><div class="stat-card"><span>Attendance Rate</span><strong><?= $rate ?>%</strong><small>Based on today's records</small></div></section>
<div class="content-grid"><section class="panel"><div class="panel-head"><div><h2>Recent Activity</h2><p>Latest attendance records across the system.</p></div><a class="btn btn-outline btn-sm" href="attendance.php">View all</a></div><div class="table-wrap"><table><thead><tr><th>Date</th><th>Student</th><th>Time in</th><th>Status</th></tr></thead><tbody><?php foreach($recent as $r): ?><tr><td><?= e($r['attendance_date']) ?></td><td><?= e($r['full_name']) ?></td><td><?= e($r['time_in'] ?: '—') ?></td><td><span class="badge <?= strtolower($r['status']) ?>"><?= e($r['status']) ?></span></td></tr><?php endforeach; if (!$recent): ?><tr><td colspan="4" class="empty">No attendance records yet.</td></tr><?php endif; ?></tbody></table></div></section><section class="panel quick-panel"><h2>Quick actions</h2><a href="users.php" class="quick-action">Manage users <span>→</span></a><a href="attendance.php" class="quick-action">Review attendance <span>→</span></a><a href="reports.php" class="quick-action">Open reports <span>→</span></a></section></div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
