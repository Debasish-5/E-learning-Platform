<?php
session_start();
include 'db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    // Query to fetch enrolled courses for the logged-in user
    $query = "
        SELECT 
            c.image_url, 
            c.title, 
            c.duration, 
            ec.enrolled_at
        FROM 
            courses c
        INNER JOIN 
            enrolled_courses ec 
        ON 
            c.id = ec.course_id
        WHERE 
            ec.user_id = :user_id
        ORDER BY 
            ec.enrolled_at DESC;
    ";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $enrolledCourses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Learning</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .dashboard {
            display: flex;
        }

        .main-content {
            flex: 1;
        }

        header {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .course-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 15px;
            text-align: center;
        }

        .course-card img {
            width: 100%;
            height: 150px;
            border-radius: 4px;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .course-card h3 {
            margin: 0 0 10px;
            font-size: 18px;
            color: #333;
        }

        .course-card p {
            margin: 0 0 10px;
            color: #555;
        }

        .btn {
            display: inline-block;
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <?php include 'shared.php'; ?> <!-- Sidebar included here -->

        <div class="main-content">
            <header>Welcome to My Learnings, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?>!</header>

            <div class="content">
                <?php if (count($enrolledCourses) > 0): ?>
                <div class="courses-grid">
                    <?php foreach ($enrolledCourses as $course): ?>
                    <div class="course-card">
                        <img src="<?php echo htmlspecialchars($course['image_url']); ?>" alt="Course Image">
                        <h3><?php echo htmlspecialchars($course['title']); ?></h3>
                        <p>Duration: <?php echo htmlspecialchars($course['duration']); ?></p>
                        <p>Enrolled At: <?php echo htmlspecialchars(date('d M Y', strtotime($course['enrolled_at']))); ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                    <p>No courses found. Please enroll in a course to start learning!</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
