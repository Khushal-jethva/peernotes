<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: login.php");
    exit();
}
echo "Welcome, " . $_SESSION['name'] . "! You are logged in as a Teacher.";
?>
<a href="logout.php">Logout</a>