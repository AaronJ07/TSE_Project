<?php
require_once '../config/database.php';
require_admin();

$totalStudents = (int) $pdo->query('SELECT COUNT(*) FROM students')->fetchColumn();
$totalCourses = (int) $pdo->query('SELECT COUNT(*) FROM courses')->fetchColumn();
$totalEnrollments = (int) $pdo->query('SELECT COUNT(*) FROM enrollments')->fetchColumn();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard | MMU Enrollment</title>
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
                    <li class="nav-item"><a class="nav-link active" href="admin_dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_students.php">Students</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_courses.php">Courses</a></li>
                    <li class="nav-item"><a class="nav-link" href="approve_enrollment.php">Approvals</a></li>
                    <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container page-shell">
        <h1 class="h3 section-title mb-4">Admin Dashboard</h1>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card stat-card">
                    <div class="card-body">
                        <p class="text-muted mb-1">Total Students</p>
                        <h2 class="display-6 mb-0"><?= e($totalStudents) ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card">
                    <div class="card-body">
                        <p class="text-muted mb-1">Total Courses</p>
                        <h2 class="display-6 mb-0"><?= e($totalCourses) ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card">
                    <div class="card-body">
                        <p class="text-muted mb-1">Total Enrollments</p>
                        <h2 class="display-6 mb-0"><?= e($totalEnrollments) ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
