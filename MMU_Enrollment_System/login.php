<?php
require_once 'config/database.php';

if (!empty($_SESSION['student_id'])) {
    redirect('student/dashboard.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = 'Please enter your email and password.';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM students WHERE email = ?');
        $stmt->execute([$email]);
        $student = $stmt->fetch();

        if ($student && password_verify($password, $student['password'])) {
            $_SESSION['student_id'] = $student['student_id'];
            $_SESSION['student_name'] = $student['name'];
            redirect('student/dashboard.php');
        }

        $error = 'Invalid email or password.';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Login | MMU Enrollment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="auth-page">
    <div class="card auth-card">
        <div class="card-body p-4 p-md-5">
            <div class="brand-badge mb-3"><span class="brand-dot"></span> MMU Student Enrollment System</div>
            <h1 class="h3 section-title mb-2">Student Login</h1>
            <p class="text-muted mb-4">Access your courses, profile, and enrollment status.</p>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= e($error) ?></div>
            <?php endif; ?>
            <?php if ($message = flash('success')): ?>
                <div class="alert alert-success"><?= e($message) ?></div>
            <?php endif; ?>

            <form method="post" novalidate>
                <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input class="form-control" type="email" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <input class="form-control" type="password" id="password" name="password" required>
                </div>
                <button class="btn btn-primary w-100" type="submit">Login</button>
            </form>

            <div class="d-flex justify-content-between mt-4">
                <a href="register.php">Create student account</a>
                <a href="admin/admin_login.php">Admin login</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
