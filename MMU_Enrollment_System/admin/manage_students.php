<?php
require_once '../config/database.php';
require_admin();

$students = $pdo->query('SELECT student_id, name, email, programme, phone FROM students ORDER BY student_id DESC')->fetchAll();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Students | MMU Enrollment</title>
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
                    <li class="nav-item"><a class="nav-link active" href="manage_students.php">Students</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_courses.php">Courses</a></li>
                    <li class="nav-item"><a class="nav-link" href="approve_enrollment.php">Approvals</a></li>
                    <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container page-shell">
        <h1 class="h3 section-title mb-3">Manage Students</h1>
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Programme</th>
                                <th>Phone</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!$students): ?>
                                <tr><td colspan="5" class="text-center py-4 text-muted">No students registered yet.</td></tr>
                            <?php endif; ?>
                            <?php foreach ($students as $student): ?>
                                <tr>
                                    <td><?= e($student['student_id']) ?></td>
                                    <td><?= e($student['name']) ?></td>
                                    <td><?= e($student['email']) ?></td>
                                    <td><?= e($student['programme']) ?></td>
                                    <td><?= e($student['phone']) ?></td>
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
