<?php
require_once '../config/database.php';
require_student();

$studentId = (int) $_SESSION['student_id'];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $programme = trim($_POST['programme'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    if ($name === '' || $programme === '' || $phone === '') {
        $error = 'Name, programme, and phone cannot be empty.';
    } else {
        $stmt = $pdo->prepare('UPDATE students SET name = ?, programme = ?, phone = ? WHERE student_id = ?');
        $stmt->execute([$name, $programme, $phone, $studentId]);
        $_SESSION['student_name'] = $name;
        flash('success', 'Profile updated successfully.');
        redirect('profile.php');
    }
}

$stmt = $pdo->prepare('SELECT * FROM students WHERE student_id = ?');
$stmt->execute([$studentId]);
$student = $stmt->fetch();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile | MMU Enrollment</title>
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
                    <li class="nav-item"><a class="nav-link active" href="profile.php">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="course_list.php">Courses</a></li>
                    <li class="nav-item"><a class="nav-link" href="enrollment_status.php">Status</a></li>
                    <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container page-shell">
        <div class="card">
            <div class="card-body p-4">
                <h1 class="h3 section-title mb-4">Student Profile</h1>
                <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
                <?php if ($message = flash('success')): ?><div class="alert alert-success"><?= e($message) ?></div><?php endif; ?>
                <form method="post" class="row g-3" novalidate>
                    <div class="col-md-6">
                        <label class="form-label" for="name">Full Name</label>
                        <input class="form-control" id="name" name="name" value="<?= e($student['name']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control" id="email" value="<?= e($student['email']) ?>" disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="programme">Programme</label>
                        <input class="form-control" id="programme" name="programme" value="<?= e($student['programme']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="phone">Phone</label>
                        <input class="form-control" id="phone" name="phone" value="<?= e($student['phone']) ?>" required>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
