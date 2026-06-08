<?php
require_once 'config/database.php';

if (empty($_SESSION['student_id'])) {
    redirect('login.php');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('student/course_list.php');
}

$courseId = (int) ($_POST['course_id'] ?? 0);
$studentId = (int) $_SESSION['student_id'];

if ($courseId <= 0) {
    flash('error', 'Please choose a valid course.');
    redirect('student/course_list.php');
}

$stmt = $pdo->prepare('SELECT course_id FROM courses WHERE course_id = ?');
$stmt->execute([$courseId]);
if (!$stmt->fetch()) {
    flash('error', 'Course not found.');
    redirect('student/course_list.php');
}

$stmt = $pdo->prepare('SELECT enrollment_id FROM enrollments WHERE student_id = ? AND course_id = ?');
$stmt->execute([$studentId, $courseId]);
if ($stmt->fetch()) {
    flash('error', 'You have already enrolled in this course.');
    redirect('student/course_list.php');
}

$stmt = $pdo->prepare('INSERT INTO enrollments (student_id, course_id, status, enroll_date) VALUES (?, ?, "Pending", NOW())');
$stmt->execute([$studentId, $courseId]);

flash('success', 'Enrollment submitted. Please wait for admin approval.');
redirect('student/enrollment_status.php');
?>
