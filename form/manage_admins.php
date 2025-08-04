<?php
session_start(); // Start the session
include 'conn.php'; // Include your database connection

// Ensure the user is a super admin
if (!isset($_SESSION['is_super_admin']) || $_SESSION['is_super_admin'] == 0) {
    header("Location: admin.php");
    exit();
}

// Handle adding/removing admins
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if (empty($username) || empty($password)) {
        echo "<div class='alert alert-warning'>Username and password cannot be empty.</div>";
        exit();
    }

    if (isset($_POST['add_admin'])) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Admin added successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . htmlspecialchars($stmt->error) . "</div>";
        }
    } elseif (isset($_POST['remove_admin'])) {
        $stmt = $conn->prepare("DELETE FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Admin removed successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . htmlspecialchars($stmt->error) . "</div>";
        }
    }
}

// Fetch existing admins
$admins = $conn->query("SELECT username FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admins</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin-top: 50px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Manage Admins</h2>

    <!-- Form to Add/Remove Admins -->
    <form method="POST" action="">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary" name="add_admin">Add Admin</button>
        <button type="submit" class="btn btn-danger" name="remove_admin">Remove Admin</button>
    </form>

    <!-- List of Existing Admins -->
    <div class="mt-4">
        <h4>Existing Admins</h4>
        <ul class="list-group">
            <?php while ($admin = $admins->fetch_assoc()): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?php echo htmlspecialchars($admin['username']); ?>
                    <form method="POST" action="" class="d-inline">
                        <input type="hidden" name="username" value="<?php echo htmlspecialchars($admin['username']); ?>">
                        <button type="submit" class="btn btn-danger btn-sm" name="remove_admin">Remove</button>
                    </form>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>

    <!-- Participants Section -->
    <div class="mt-4">
        <h4>Access Participants</h4>
        <div class="mb-3">
            <label for="eventSelect" class="form-label">Select Event:</label>
            <select class="form-select" id="eventSelect">
                <option selected disabled>Select an event</option>
                <option value="event1">Event 1</option>
                <option value="event2">Event 2</option>
                <option value="event3">Event 3</option>
            </select>
        </div>
        <div id="participantTable" class="table-responsive">
            <!-- Participants table will be loaded here -->
        </div>
        <div class="loading">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $('#eventSelect').change(function(){
        var event = $(this).val();
        if(event){
            $('.loading').show();
            $.ajax({
                url: 'load_participants.php',
                type: 'POST',
                data: {event: event},
                success: function(data){
                    $('#participantTable').html(data);
                    $('.loading').hide();
                },
                error: function(){
                    $('#participantTable').html('<div class="alert alert-danger">Error loading data. Please try again.</div>');
                    $('.loading').hide();
                }
            });
        } else {
            $('#participantTable').html('');
        }
    });
});
</script>

</body>
</html>
