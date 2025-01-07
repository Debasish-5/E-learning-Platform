<?php
session_start();
include 'db_connection.php';

// Fetch the course ID from the URL
$course_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch course details from the database
$query = "SELECT * FROM courses WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->execute(['id' => $course_id]);
$course = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$course) {
    echo "Course not found!";
    exit;
}

// Check if the user is logged in
$user_id = $_SESSION['user_id'] ?? 0;
$username = $_SESSION['username'] ?? 'Guest';

if (!$user_id) {
    header("Location: login_signup.php");
    exit;
}

// Fetch the user's progress and playback time
$progress_query = "SELECT progress, playback_time FROM course_progress WHERE course_id = :course_id AND user_id = :user_id";
$progress_stmt = $pdo->prepare($progress_query);
$progress_stmt->execute(['course_id' => $course_id, 'user_id' => $user_id]);
$progress_data = $progress_stmt->fetch(PDO::FETCH_ASSOC);

$current_progress = $progress_data['progress'] ?? 0;
$current_playback_time = $progress_data['playback_time'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($course['title']); ?> - Course Player</title>
    <link rel="stylesheet" href="course_player.css">
</head>
<body>
    <div class="course-player">
        <div class="user-container">
            <button onclick="window.history.back()" class="back-btn">Back</button>
            <div class="user-info">
                Hi, <?php echo htmlspecialchars($username); ?>
            </div>
        </div>
        <div class="video-container">
            <h2><?php echo htmlspecialchars($course['title']); ?></h2>
            <div id="player"></div> <!-- YouTube Player will be embedded here -->

            <!-- Progress Bar -->
            <div class="progress-container">
                <label for="progress">Progress:</label>
                <progress id="progress" value="<?php echo $current_progress; ?>" max="100"></progress>
                <span id="progress-text"><?php echo $current_progress; ?>%</span>
            </div>
        </div>
    </div>

    <script>
        let player;
        let currentProgress = <?php echo $current_progress; ?>;
        let playbackTime = <?php echo $current_playback_time; ?>;

        // Initialize YouTube Player
        function onYouTubeIframeAPIReady() {
            player = new YT.Player('player', {
                videoId: '<?php echo htmlspecialchars($course['youtube_video_id']); ?>',
                playerVars: {
                    start: playbackTime // Start video from saved playback time
                },
                events: {
                    'onStateChange': onPlayerStateChange
                }
            });
        }

        // Update progress during playback
        function onPlayerStateChange(event) {
            if (event.data === YT.PlayerState.PLAYING) {
                setInterval(() => {
                    const duration = player.getDuration();
                    const currentTime = player.getCurrentTime();
                    const progress = Math.floor((currentTime / duration) * 100);

                    if (progress > currentProgress) {
                        currentProgress = progress;
                        playbackTime = currentTime;

                        // Update progress on the progress bar
                        document.getElementById('progress').value = currentProgress;
                        document.getElementById('progress-text').textContent = currentProgress + '%';
                    }
                }, 1000); // Update every second locally
            }
        }

        // Update progress in the database when the user leaves the page
        window.addEventListener('beforeunload', () => {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'save_progress.php', false); // Synchronous request
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send(`user_id=<?php echo $user_id; ?>&course_id=<?php echo $course_id; ?>&progress=${currentProgress}&time=${Math.floor(playbackTime)}`);
        });

        // Load the YouTube API script
        const tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        const firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    </script>
</body>
</html>
