<?php
require_once '../config/database.php';
require_student();

$stmt = $pdo->prepare(
    'SELECT e.*, c.course_code, c.course_name, c.credit_hours
     FROM enrollments e
     JOIN courses c ON e.course_id = c.course_id
     WHERE e.student_id = ?
     ORDER BY e.enroll_date DESC'
);
$stmt->execute([$_SESSION['student_id']]);
$enrollments = $stmt->fetchAll();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Enrollment Status | MMU Enrollment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">MMU Enrollment</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="course_list.php">Courses</a></li>
                    <li class="nav-item"><a class="nav-link active" href="enrollment_status.php">Status</a></li>
                    <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container page-shell">
        <h1 class="h3 section-title mb-3">Enrollment Status</h1>
        <?php if ($message = flash('success')): ?><div class="alert alert-success"><?= e($message) ?></div><?php endif; ?>
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Course</th>
                                <th>Credit Hours</th>
                                <th>Status</th>
                                <th>Enroll Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!$enrollments): ?>
                                <tr><td colspan="4" class="text-center py-4 text-muted">No enrollment records found.</td></tr>
                            <?php endif; ?>
                            <?php foreach ($enrollments as $row): ?>
                                <?php $statusClass = 'badge-' . strtolower($row['status']); ?>
                                <tr>
                                    <td><?= e($row['course_code']) ?> - <?= e($row['course_name']) ?></td>
                                    <td><?= e($row['credit_hours']) ?></td>
                                    <td><span class="badge <?= e($statusClass) ?>"><?= e($row['status']) ?></span></td>
                                    <td><?= e($row['enroll_date']) ?></td>
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
