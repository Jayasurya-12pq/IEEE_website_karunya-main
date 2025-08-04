<?php
include 'conn.php';

if (isset($_POST['event'])) {
    $event = $_POST['event'];

    // Determine the correct table based on the event
    $table_name = "";
    if ($event == "event1") {
        $table_name = "event1";
    } elseif ($event == "event2") {
        $table_name = "event2";
    } elseif ($event == "event3") {
        $table_name = "event3";
    }

    // Fetch members from the selected event table
    $sql = "SELECT * FROM $table_name";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<table class="table table-striped table-bordered">';
        echo '<thead class="table-dark">';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Name</th>';
        echo '<th>Registration ID</th>';
        echo '<th>Division</th>';
        echo '<th>Year</th>';
        echo '<th>College</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . $row['name'] . '</td>';
            echo '<td>' . $row['reg_id'] . '</td>';
            echo '<td>' . $row['division'] . '</td>';
            echo '<td>' . $row['year'] . '</td>';
            echo '<td>' . $row['college'] . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<div class="alert alert-info">No members registered for this event.</div>';
    }
} else {
    echo '<div class="alert alert-danger">Invalid request.</div>';
}
?>
