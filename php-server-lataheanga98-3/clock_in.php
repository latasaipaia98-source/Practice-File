<?php
session_start();
include "config.php";

if (!isset($_SESSION["employee_id"])) {
    header("Location: login.php");
    exit;
}

$employee_id = $_SESSION["employee_id"];

// Check if already clocked in
$sql = "SELECT * FROM attendance 
        WHERE employee_id = ? AND clock_out IS NULL 
        ORDER BY id DESC 
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $employee_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $sql = "INSERT INTO attendance (employee_id, clock_in) VALUES (?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $employee_id);
    $stmt->execute();
}

header("Location: attendance.php");
exit;
?>