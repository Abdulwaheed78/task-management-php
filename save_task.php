<?php
include_once "connect.php";
// Get form data
$title = $_POST['title'];
$description = $_POST['description'];
$date = $_POST['date'];
$status = $_POST['status'];

// Construct SQL query
$sql = "INSERT INTO tk (title, `desc`, addtime, status,duedate) VALUES ('$title', '$description', NOW(), '$status' , '$date')";

// Execute the query
if ($conn->query($sql) === TRUE) {
    echo "Task added successfully";
} else {
    echo "Error: " . $conn->error;
}
