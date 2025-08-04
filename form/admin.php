<?php
include 'conn.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Event Registrations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .table {
            margin-top: 20px;
        }
        .loading {
            text-align: center;
            padding: 20px;
            display: none;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3 class="text-center">Event Registrations</h3>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="eventSelect" class="form-label">Select Event:</label>
                <select class="form-select" id="eventSelect">
                    <option selected disabled>Select an event</option>
                    <option value="event1">Event 1</option>
                    <option value="event2">Event 2</option>
                    <option value="event3">Event 3</option>
                </select>
            </div>
            <div id="memberTable" class="table-responsive">
                <!-- Members table will be loaded here -->
            </div>
            <div class="loading">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('#eventSelect').change(function(){
        var event = $(this).val();
        if(event){
            $('.loading').show();
            $.ajax({
                url: 'load_members.php',
                type: 'POST',
                data: {event: event},
                success: function(data){
                    $('#memberTable').html(data);
                    $('.loading').hide();
                },
                error: function(){
                    $('#memberTable').html('<div class="alert alert-danger">Error loading data. Please try again.</div>');
                    $('.loading').hide();
                }
            });
        } else {
            $('#memberTable').html('');
        }
    });
});
</script>

</body>
</html>
