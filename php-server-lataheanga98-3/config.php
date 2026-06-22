<?php
$conn = new mysqli("localhost", "root", "", "workday_lite");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>