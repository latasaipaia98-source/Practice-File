<?php
session_start();
include "config.php";

if (!isset($_SESSION["employee_id"])) {
    header("Location: login.php");
    exit;
}

$employee_id = $_SESSION["employee_id"];

$sql = "UPDATE attendance
        SET clock_out = NOW(),
            total_hours = TIMESTAMPDIFF(MINUTE, clock_in, NOW()) / 60
        WHERE employee_id = ? 
        AND clock_out IS NULL
        ORDER BY id DESC
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $employee_id);
$stmt->execute();

header("Location: attendance.php");
exit;
?>