<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = intval($_POST['user_id']);
    $course_id = intval($_POST['course_id']);
    $progress = intval($_POST['progress']);
    $playback_time = intval($_POST['time']);

    // Update progress and playback time in the database
    $query = "INSERT INTO course_progress (user_id, course_id, progress, playback_time)
              VALUES (:user_id, :course_id, :progress, :playback_time)
              ON DUPLICATE KEY UPDATE 
              progress = GREATEST(progress, :progress),
              playback_time = :playback_time";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'user_id' => $user_id,
        'course_id' => $course_id,
        'progress' => $progress,
        'playback_time' => $playback_time
    ]);
}
?>
