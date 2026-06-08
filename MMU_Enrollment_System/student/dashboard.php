<?php
require_once '../config/database.php';
require_student();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Dashboard | MMU Enrollment</title>
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
                    <li class="nav-item"><a class="nav-link active" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="course_list.php">Courses</a></li>
                    <li class="nav-item"><a class="nav-link" href="enrollment_status.php">Status</a></li>
                    <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container page-shell">
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-body p-4">
                        <h1 class="section-title h3">Welcome, <?= e($_SESSION['student_name']) ?></h1>
                        <p class="text-muted mb-4">Use this dashboard to view courses, submit enrollments, and track approval status.</p>
                        <div class="d-flex flex-wrap gap-2">
                            <a class="btn btn-primary" href="course_list.php">View Courses</a>
                            <a class="btn btn-outline-primary" href="enrollment_status.php">Check Status</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card stat-card h-100">
                    <div class="card-body p-4">
                        <h2 class="h5">Quick Actions</h2>
                        <p class="text-muted">Keep your student information current before applying for courses.</p>
                        <a class="btn btn-outline-primary w-100" href="profile.php">Update Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
