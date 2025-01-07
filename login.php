<?php
session_start();
include 'db_connection.php'; // Include your database connection file

$message = ''; // Variable to store messages

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'login') {
        // Handle Login
        $email = $_POST['email'];
        $password = $_POST['password'];

        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($password === $user['password']) {
                    // Successful login
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    header("Location: index.php"); // Redirect to the homepage
                    exit;
                } else {
                    $message = "Invalid password.";
                }
            } else {
                $message = "Invalid email.";
            }
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'signup') {
        // Handle Signup
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        try {
            // Check if email already exists
            $checkStmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $checkStmt->bindParam(':email', $email, PDO::PARAM_STR);
            $checkStmt->execute();

            if ($checkStmt->rowCount() > 0) {
                $message = "Email already exists. Please log in.";
            } else {
                // Insert new user
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    $message = "Signup successful! Please log in.";
                } else {
                    $message = "Error during signup.";
                }
            }
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Signup</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
        <div class="container">
        <div class="tabs">
            <button class="tab active" onclick="switchTab('login')">Login</button>
            <button class="tab" onclick="switchTab('signup')">Signup</button>
        </div>
        <?php if ($message): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <!-- Login Form -->
        <div class="form-container" id="login">
            <form method="POST" action="">
                <input type="hidden" name="action" value="login">
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" class="submit">Login</button>
            </form>
        </div>
        <!-- Signup Form -->
        <div class="form-container hidden" id="signup">
            <form method="POST" action="">
                <input type="hidden" name="action" value="signup">
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" required>
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" class="submit">Signup</button>
            </form>
        </div>
    </div>

    <script>
        function switchTab(tab) {
            document.querySelectorAll('.form-container').forEach(container => {
                container.classList.add('hidden');
            });
            document.getElementById(tab).classList.remove('hidden');
            document.querySelectorAll('.tab').forEach(button => {
                button.classList.remove('active');
            });
            document.querySelector(`.tab[onclick="switchTab('${tab}')"]`).classList.add('active');
        }
    </script>
</body>
</html>
