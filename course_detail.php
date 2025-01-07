<?php
session_start();
include 'db_connection.php';

$course_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch course details
$query = "SELECT * FROM courses WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->execute(['id' => $course_id]);
$course = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$course) {
    echo "Course not found!";
    exit;
}

// Check if user is logged in
$user_id = $_SESSION['user_id'] ?? 0;
$username = $_SESSION['username'] ?? 'Guest';

// Check if the user is enrolled in the course
$is_enrolled = false;
if ($user_id) {
    $enrollmentQuery = "SELECT * FROM enrolled_courses WHERE user_id = :user_id AND course_id = :course_id";
    $enrollmentStmt = $pdo->prepare($enrollmentQuery);
    $enrollmentStmt->execute(['user_id' => $user_id, 'course_id' => $course_id]);
    $is_enrolled = $enrollmentStmt->rowCount() > 0;
}

// Display the progress if enrolled
$progress = 0;
if ($is_enrolled) {
    $progressQuery = "SELECT progress FROM course_progress WHERE user_id = :user_id AND course_id = :course_id";
    $progressStmt = $pdo->prepare($progressQuery);
    $progressStmt->execute(['user_id' => $user_id, 'course_id' => $course_id]);
    $progressData = $progressStmt->fetch(PDO::FETCH_ASSOC);
    $progress = $progressData['progress'] ?? 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($course['title']); ?></title>
    <link rel="stylesheet" href="course_details.css">
</head>
<body>
    <div class="course-details">
        <div class="user-container">
            <button onclick="window.history.back()" class="back-btn">Back</button>
            <div class="user-info">
                Hi, <?php echo htmlspecialchars($username); ?>
            </div>
        </div>
        <div class="title-container">
            <header><?php echo htmlspecialchars($course['title']); ?></header>
        </div>
        <div class="details-grid">
            <div class="course-card">
                <img src="<?php echo htmlspecialchars($course['image_url']); ?>" alt="Course Image">
                <p>Duration: <?php echo htmlspecialchars($course['duration']); ?></p>
                <?php if ($is_enrolled): ?>
                    <button class="btn green" onclick="window.location.href='course_player.php?id=<?php echo $course_id; ?>'">Let's Start</button>
                <?php else: ?>
                    <form method="POST" action="enroll.php">
                        <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
                        <button type="submit" class="btn">Enroll Now</button>
                    </form>
                <?php endif; ?>
            </div>
            <div class="description">
                <h3>Description</h3>
                <p class="paragraph-spacing">
                    <?php echo nl2br(htmlspecialchars($course['description'])); ?>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
