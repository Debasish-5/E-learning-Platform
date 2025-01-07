<?php
session_start();
include 'db_connection.php';

// Fetch courses from the database
$query = "SELECT * FROM courses";
$stmt = $pdo->query($query);
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard">
        <?php include 'shared.php'; ?>
        <div class="main-content">
            <header>Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?>!</header>
            <div class="content">
                <div class="courses-grid">
                    <?php foreach ($courses as $course): ?>
                    <div class="course-card">
                        <img src="<?php echo htmlspecialchars($course['image_url']); ?>" alt="Course Image">
                        <h3><?php echo htmlspecialchars($course['title']); ?></h3>
                        <p>Duration: <?php echo htmlspecialchars($course['duration']); ?></p>
                        <form method="POST" action="enroll.php">
                            <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                            <button type="submit" class="btn">Enroll Now</button>
                        </form>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
