<?php
require_once '../config/database.php';
require_student();

$stmt = $pdo->query('SELECT * FROM courses ORDER BY course_code');
$courses = $stmt->fetchAll();

$stmt = $pdo->prepare('SELECT course_id FROM enrollments WHERE student_id = ?');
$stmt->execute([$_SESSION['student_id']]);
$enrolledIds = array_column($stmt->fetchAll(), 'course_id');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Course List | MMU Enrollment</title>
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
                    <li class="nav-item"><a class="nav-link active" href="course_list.php">Courses</a></li>
                    <li class="nav-item"><a class="nav-link" href="enrollment_status.php">Status</a></li>
                    <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container page-shell">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3 section-title mb-0">Available Courses</h1>
        </div>
        <?php if ($message = flash('success')): ?><div class="alert alert-success"><?= e($message) ?></div><?php endif; ?>
        <?php if ($message = flash('error')): ?><div class="alert alert-danger"><?= e($message) ?></div><?php endif; ?>
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Code</th>
                                <th>Course Name</th>
                                <th>Credit Hours</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($courses as $course): ?>
                                <tr>
                                    <td><?= e($course['course_code']) ?></td>
                                    <td><?= e($course['course_name']) ?></td>
                                    <td><?= e($course['credit_hours']) ?></td>
                                    <td>
                                        <?php if (in_array($course['course_id'], $enrolledIds)): ?>
                                            <span class="badge bg-secondary">Already Enrolled</span>
                                        <?php else: ?>
                                            <form method="post" action="../enroll_process.php">
                                                <input type="hidden" name="course_id" value="<?= e($course['course_id']) ?>">
                                                <button class="btn btn-sm btn-primary" type="submit">Enroll</button>
                                            </form>
                                        <?php endif; ?>
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
