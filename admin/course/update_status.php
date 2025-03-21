<?php
// Include the database connection
include("../../includes/dbconnection.php");

if (isset($_GET['course_id']) && isset($_GET['status'])) {
    // Sanitize the input
    $course_id = intval($_GET['course_id']);
    $status = intval($_GET['status']); // should be either 0 or 1

    // Check if the course ID and status are valid
    if ($course_id <= 0 || !in_array($status, [0, 1])) {
        echo "Invalid course ID or status value.";
        exit;
    }

    // Prepare the SQL query to update the status
    $sql = "UPDATE course SET status = '$status' WHERE id = '$course_id'";

    // Check for SQL query error
    if (mysqli_query($conn, $sql)) {
        echo "Status updated successfully";
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }
} else {
    echo "Missing course ID or status parameter.";
}
?>
