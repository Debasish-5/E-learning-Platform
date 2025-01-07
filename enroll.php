<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login_signup.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['course_id'])) {
    $user_id = $_SESSION['user_id'];
    $course_id = intval($_POST['course_id']);

    // Check if already enrolled
    $checkQuery = "SELECT * FROM enrolled_courses WHERE user_id = :user_id AND course_id = :course_id";
    $checkStmt = $pdo->prepare($checkQuery);
    $checkStmt->execute(['user_id' => $user_id, 'course_id' => $course_id]);

    if ($checkStmt->rowCount() > 0) {
        header("Location: course_detail.php?id=$course_id&message=Already enrolled");
        exit;
    }

    // Enroll user in course
    $query = "INSERT INTO enrolled_courses (user_id, course_id) VALUES (:user_id, :course_id)";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['user_id' => $user_id, 'course_id' => $course_id]);

    header("Location: course_detail.php?id=$course_id");
    exit;
}
?>
