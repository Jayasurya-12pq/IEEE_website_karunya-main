<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $servername = "localhost";;
    $username = "christal_data";
    $password = "Christal123@456"; // Update with your MySQL password
    $dbname = "christal_data";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $event = $_POST['event'];
    $name = $_POST['name'];
    $reg_id = $_POST['regid'];
    $division = $_POST['division'];
    $year = $_POST['year'];
    $college = $_POST['college'];

    // Determine the correct table based on the event
    $table_name = "";
    if ($event == "event1") {
        $table_name = "event1";
    } elseif ($event == "event2") {
        $table_name = "event2";
    } elseif ($event == "event3") {
        $table_name = "event3";
    }

    // Insert data into the selected event table
    $sql = "INSERT INTO $table_name (name, reg_id, division, year, college) VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $reg_id, $division, $year, $college);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the connection
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link href="form.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/2af47861c3.js" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration</title>
</head>
<body>
  <video autoplay muted loop class="bg-video">
    <source src="home_bg.mp4" type="video/mp4">
    Your browser does not support the video tag.
</video>
  <div class="container form-container">
    <h2 class="text-center">Registration Form</h2>
    <form method="post" action="">
    <div class="mb-3 input-group">
        <span class="input-group-text" id="input-group-left-example">Event</span>
        <select class="form-select" id="event" name="event" required>
            <option selected disabled>Select an event</option>
            <option value="event1">Event 1</option>
            <option value="event2">Event 2</option>
            <option value="event3">Event 3</option>
        </select>
    </div>
    <div class="mb-3 input-group">
        <span class="input-group-text" id="input-group-left-example">Name</span>
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
    </div>
    <div class="mb-3 input-group">
        <span class="input-group-text" id="input-group-left-example">Registration ID</span>
        <input type="text" class="form-control" id="regid" name="regid" placeholder="Enter your registration ID" required>
    </div>
    <div class="mb-3 input-group">
        <span class="input-group-text" id="input-group-left-example">Division</span>
        <input type="text" class="form-control" id="division" name="division" placeholder="Enter your division" required>
    </div>
    <div class="mb-3 input-group">
        <span class="input-group-text" id="input-group-left-example">Year</span>
        <input type="text" class="form-control" id="year" name="year" placeholder="Enter your year" required>
    </div>
    <div class="mb-3 input-group">
        <span class="input-group-text" id="input-group-left-example">College</span>
        <input type="text" class="form-control" id="college" name="college" placeholder="Enter your college name" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Register</button>
</form>


</div>
</body>
</html>