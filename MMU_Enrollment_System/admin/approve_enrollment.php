<?php
require_once '../config/database.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enrollmentId = (int) ($_POST['enrollment_id'] ?? 0);
    $status = $_POST['status'] ?? '';

    if ($enrollmentId > 0 && in_array($status, ['Approved', 'Rejected'], true)) {
        $stmt = $pdo->prepare('UPDATE enrollments SET status = ? WHERE enrollment_id = ?');
        $stmt->execute([$status, $enrollmentId]);
        flash('success', "Enrollment marked as $status.");
    }

    redirect('approve_enrollment.php');
}

$stmt = $pdo->query(
    'SELECT e.*, s.name AS student_name, s.email, c.course_code, c.course_name
     FROM enrollments e
     JOIN students s ON e.student_id = s.student_id
     JOIN courses c ON e.course_id = c.course_id
     ORDER BY e.enroll_date DESC'
);
$enrollments = $stmt->fetchAll();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Approve Enrollment | MMU Enrollment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="admin_dashboard.php">MMU Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_students.php">Students</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_courses.php">Courses</a></li>
                    <li class="nav-item"><a class="nav-link active" href="approve_enrollment.php">Approvals</a></li>
                    <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container page-shell">
        <h1 class="h3 section-title mb-3">Approve Enrollment</h1>
        <?php if ($message = flash('success')): ?><div class="alert alert-success"><?= e($message) ?></div><?php endif; ?>
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Student</th>
                                <th>Email</th>
                                <th>Course</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!$enrollments): ?>
                                <tr><td colspan="6" class="text-center py-4 text-muted">No enrollment requests yet.</td></tr>
                            <?php endif; ?>
                            <?php foreach ($enrollments as $row): ?>
                                <?php $statusClass = 'badge-' . strtolower($row['status']); ?>
                                <tr>
                                    <td><?= e($row['student_name']) ?></td>
                                    <td><?= e($row['email']) ?></td>
                                    <td><?= e($row['course_code']) ?> - <?= e($row['course_name']) ?></td>
                                    <td><span class="badge <?= e($statusClass) ?>"><?= e($row['status']) ?></span></td>
                                    <td><?= e($row['enroll_date']) ?></td>
                                    <td>
                                        <form method="post" class="d-inline">
                                            <input type="hidden" name="enrollment_id" value="<?= e($row['enrollment_id']) ?>">
                                            <input type="hidden" name="status" value="Approved">
                                            <button class="btn btn-sm btn-success" type="submit">Approve</button>
                                        </form>
                                        <form method="post" class="d-inline">
                                            <input type="hidden" name="enrollment_id" value="<?= e($row['enrollment_id']) ?>">
                                            <input type="hidden" name="status" value="Rejected">
                                            <button class="btn btn-sm btn-danger" type="submit">Reject</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
