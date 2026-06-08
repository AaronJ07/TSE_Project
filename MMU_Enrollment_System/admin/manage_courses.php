<?php
require_once '../config/database.php';
require_admin();

$error = '';
$editingCourse = null;

if (isset($_GET['delete'])) {
    $courseId = (int) $_GET['delete'];
    if ($courseId > 0) {
        $stmt = $pdo->prepare('DELETE FROM courses WHERE course_id = ?');
        $stmt->execute([$courseId]);
        flash('success', 'Course deleted successfully.');
    }
    redirect('manage_courses.php');
}

if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare('SELECT * FROM courses WHERE course_id = ?');
    $stmt->execute([(int) $_GET['edit']]);
    $editingCourse = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $courseId = (int) ($_POST['course_id'] ?? 0);
    $code = strtoupper(trim($_POST['course_code'] ?? ''));
    $name = trim($_POST['course_name'] ?? '');
    $credits = (int) ($_POST['credit_hours'] ?? 0);

    if ($code === '' || $name === '' || $credits <= 0) {
        $error = 'Course code, course name, and credit hours are required.';
    } else {
        if ($courseId > 0) {
            $stmt = $pdo->prepare('UPDATE courses SET course_code = ?, course_name = ?, credit_hours = ? WHERE course_id = ?');
            $stmt->execute([$code, $name, $credits, $courseId]);
            flash('success', 'Course updated successfully.');
        } else {
            $stmt = $pdo->prepare('INSERT INTO courses (course_code, course_name, credit_hours) VALUES (?, ?, ?)');
            $stmt->execute([$code, $name, $credits]);
            flash('success', 'Course added successfully.');
        }
        redirect('manage_courses.php');
    }
}

$courses = $pdo->query('SELECT * FROM courses ORDER BY course_code')->fetchAll();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Courses | MMU Enrollment</title>
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
                    <li class="nav-item"><a class="nav-link active" href="manage_courses.php">Courses</a></li>
                    <li class="nav-item"><a class="nav-link" href="approve_enrollment.php">Approvals</a></li>
                    <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container page-shell">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h1 class="h4 section-title mb-3"><?= $editingCourse ? 'Edit Course' : 'Add Course' ?></h1>
                        <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
                        <?php if ($message = flash('success')): ?><div class="alert alert-success"><?= e($message) ?></div><?php endif; ?>
                        <form method="post" novalidate>
                            <input type="hidden" name="course_id" value="<?= e($editingCourse['course_id'] ?? 0) ?>">
                            <div class="mb-3">
                                <label class="form-label" for="course_code">Course Code</label>
                                <input class="form-control" id="course_code" name="course_code" value="<?= e($editingCourse['course_code'] ?? '') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="course_name">Course Name</label>
                                <input class="form-control" id="course_name" name="course_name" value="<?= e($editingCourse['course_name'] ?? '') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="credit_hours">Credit Hours</label>
                                <input class="form-control" type="number" min="1" id="credit_hours" name="credit_hours" value="<?= e($editingCourse['credit_hours'] ?? '') ?>" required>
                            </div>
                            <button class="btn btn-primary w-100" type="submit"><?= $editingCourse ? 'Update Course' : 'Add Course' ?></button>
                            <?php if ($editingCourse): ?><a class="btn btn-outline-secondary w-100 mt-2" href="manage_courses.php">Cancel</a><?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Credits</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($courses as $course): ?>
                                        <tr>
                                            <td><?= e($course['course_code']) ?></td>
                                            <td><?= e($course['course_name']) ?></td>
                                            <td><?= e($course['credit_hours']) ?></td>
                                            <td>
                                                <a class="btn btn-sm btn-outline-primary" href="manage_courses.php?edit=<?= e($course['course_id']) ?>">Edit</a>
                                                <a class="btn btn-sm btn-outline-danger" href="manage_courses.php?delete=<?= e($course['course_id']) ?>" onclick="return confirm('Delete this course? Related enrollments will also be removed.');">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
