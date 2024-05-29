<?php
// Include the database connection file
include_once "connect.php";

// Check if the task ID and status are set in the POST request
if(isset($_POST['id']) && isset($_POST['status'])) {
    // Sanitize the input data
    $task_id = $_POST['id'];
    $status = $_POST['status'];

    // Prepare and execute the SQL query to update the task status
    $stmt = $conn->prepare("UPDATE tk SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $task_id);
    if ($stmt->execute()) {
        // Task status updated successfully
        echo json_encode(array('status' => 'success', 'message' => 'Task status updated successfully'));
    } else {
        // Error updating task status
        echo json_encode(array('status' => 'error', 'message' => 'Error updating task status'));
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // Invalid request
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request'));
}
?>
