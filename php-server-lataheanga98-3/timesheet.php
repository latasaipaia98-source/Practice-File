<?php
session_start();
include "config.php";

if (!isset($_SESSION["employee_id"])) {
    header("Location: login.php");
    exit;
}

$employee_id = $_SESSION["employee_id"];
$name = $_SESSION["name"] ?? "Employee";

$sql = "SELECT * FROM attendance 
        WHERE employee_id = ? 
        ORDER BY id DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $employee_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Timesheet</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<div class="dashboard">
    <aside class="sidebar">
        <h2>Workday <span>Lite</span></h2>
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="attendance.php">Attendance</a>
            <a href="timesheet.php">Timesheet</a>
            <a href="#">Leave Requests</a>
            <a href="#">Profile</a>
            <a href="logout.php">Logout</a>
        </nav>
    </aside>

    <main class="main-content">
        <header>
            <h1>Timesheet</h1>
            <p>Viewing attendance records for <?php echo htmlspecialchars($name); ?></p>
        </header>

        <section class="table-section">
            <h2>My Attendance Records</h2>

            <table>
                <tr>
                    <th>Date</th>
                    <th>Clock In</th>
                    <th>Clock Out</th>
                    <th>Total Hours</th>
                </tr>

                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars(date("Y-m-d", strtotime($row["clock_in"]))); ?></td>
                            <td><?php echo htmlspecialchars($row["clock_in"]); ?></td>
                            <td>
                                <?php 
                                echo $row["clock_out"] 
                                    ? htmlspecialchars($row["clock_out"]) 
                                    : "Still clocked in"; 
                                ?>
                            </td>
                            <td>
                                <?php 
                                echo $row["total_hours"] 
                                    ? htmlspecialchars(number_format($row["total_hours"], 2)) 
                                    : "0.00"; 
                                ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No timesheet records yet.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </section>
    </main>
</div>

</body>
</html>