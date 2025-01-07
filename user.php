<?php
session_start();
include 'db_connection.php';

// Fetch user data
$user_id = $_SESSION['user_id'] ?? null;
$message = '';

if ($user_id) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    header("Location: login.php");
    exit;
}

// Handle profile picture upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_pic'])) {
    $target_dir = "uploads/";
    $filename = basename($_FILES["profile_pic"]["name"]);
    $target_file = $target_dir . time() . "_" . $filename; // Rename file to avoid conflicts
    $uploadOk = true;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validate file type
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowedTypes)) {
        $message = "Only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = false;
    }

    // Move file to 'uploads' folder
    if ($uploadOk && move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
        // Update user image in the database
        try {
            $stmt = $pdo->prepare("UPDATE users SET user_img = :user_img WHERE id = :user_id");
            $stmt->bindParam(':user_img', $target_file);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();

            $message = "Profile picture updated successfully!";
            $user['user_img'] = $target_file; // Update the image in local data
        } catch (PDOException $e) {
            $message = "Error updating profile picture: " . $e->getMessage();
        }
    } elseif ($uploadOk) {
        $message = "There was an error uploading your file.";
    }
}

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $username = $_POST['username'] ?? $user['username'];
    $email = $_POST['email'] ?? $user['email'];

    try {
        $stmt = $pdo->prepare("UPDATE users SET username = :username, email = :email WHERE id = :user_id");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        $message = "Profile updated successfully!";
        $user['username'] = $username;
        $user['email'] = $email;
    } catch (PDOException $e) {
        $message = "Error updating profile: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="user.css">
</head>
<body>
    <div class="dashboard">
        <?php include 'shared.php'; ?>
        <div class="main-content">
            <header>Welcome to User Profile, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?>!</header>
                <div class="profile-container">
                    <div class="profile-card">
                        <img src="<?php echo htmlspecialchars($user['user_img'] ?? 'uploads/default.png'); ?>" alt="Profile Image">
                        <form method="POST" enctype="multipart/form-data">
                            <input type="file" name="profile_pic" accept="image/*" required>
                            <button type="submit">Upload Photo</button>
                        </form>
                    </div>
                    <div class="user-info">
                        <form method="POST">
                            <label>Username:</label>
                            <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                            
                            <label>Email:</label>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            
                                                        
                            <label>Password:</label>
                            <input type="password" name="password" value="<?php echo htmlspecialchars($user['password']); ?>" required>

                            <button type="submit" name="update_profile" id="btn1">Update Profile</button>
                            <a href="logout.php"><button type="button" id="btn2">Logout</button></a>
                            <?php if ($message): ?>
                                <p style="color: green;"><?php echo htmlspecialchars($message); ?></p>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
