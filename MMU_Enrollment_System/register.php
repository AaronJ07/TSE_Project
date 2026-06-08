<?php
require_once 'config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $programme = trim($_POST['programme'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    if ($name === '' || $email === '' || $password === '' || $programme === '' || $phone === '') {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } else {
        $stmt = $pdo->prepare('SELECT student_id FROM students WHERE email = ?');
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $error = 'This email is already registered.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO students (name, email, password, programme, phone) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$name, $email, $hash, $programme, $phone]);
            flash('success', 'Registration successful. Please login.');
            redirect('login.php');
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | MMU Enrollment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="auth-page">
    <div class="card auth-card">
        <div class="card-body p-4 p-md-5">
            <div class="brand-badge mb-3"><span class="brand-dot"></span> MMU Student Enrollment System</div>
            <h1 class="h3 section-title mb-2">Create Account</h1>
            <p class="text-muted mb-4">Register as a student to enroll in available courses.</p>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= e($error) ?></div>
            <?php endif; ?>

            <form method="post" novalidate>
                <div class="mb-3">
                    <label class="form-label" for="name">Full Name</label>
                    <input class="form-control" type="text" id="name" name="name" value="<?= e($_POST['name'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input class="form-control" type="email" id="email" name="email" value="<?= e($_POST['email'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <input class="form-control" type="password" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="programme">Programme</label>
                    <input class="form-control" type="text" id="programme" name="programme" value="<?= e($_POST['programme'] ?? '') ?>" placeholder="e.g. Software Engineering" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="phone">Phone</label>
                    <input class="form-control" type="text" id="phone" name="phone" value="<?= e($_POST['phone'] ?? '') ?>" required>
                </div>
                <button class="btn btn-primary w-100" type="submit">Register</button>
            </form>

            <p class="mt-4 mb-0 text-center">Already registered? <a href="login.php">Login here</a></p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
