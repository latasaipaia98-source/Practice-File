<?php
session_start();
include "config.php";

if (!isset($_SESSION["employee_id"])) {
    header("Location: login.php");
    exit;
}

$employee_id = $_SESSION["employee_id"];
$name = $_SESSION["name"] ?? "Employee";
$message = "";

// Clock In
if (isset($_POST["clock_in"])) {
    $sql = "INSERT INTO attendance (employee_id, clock_in) VALUES (?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $employee_id);

    if ($stmt->execute()) {
        $message = "Clocked in successfully!";
    }
}

// Clock Out
if (isset($_POST["clock_out"])) {
    $sql = "UPDATE attendance 
            SET clock_out = NOW(),
                total_hours = TIMESTAMPDIFF(MINUTE, clock_in, NOW()) / 60
            WHERE employee_id = ? AND clock_out IS NULL
            ORDER BY id DESC
            LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $employee_id);

    if ($stmt->execute()) {
        $message = "Clocked out successfully!";
    }
}

// Get latest attendance
$sql = "SELECT * FROM attendance WHERE employee_id = ? ORDER BY id DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $employee_id);
$stmt->execute();
$result = $stmt->get_result();
$latest = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Attendance</title>
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
            <h1>Attendance</h1>
            <p>Welcome, <?php echo htmlspecialchars($name); ?></p>
        </header>

        <?php if ($message): ?>
            <p style="background:#dcfce7; color:#166534; padding:12px; border-radius:8px;">
                <?php echo htmlspecialchars($message); ?>
            </p>
        <?php endif; ?>

        <section class="cards">
            <div class="card">
                <h3>Clock In</h3>
                <form method="POST">
                    <button type="submit" name="clock_in">Clock In</button>
                </form>
            </div>

            <div class="card">
                <h3>Clock Out</h3>
                <form method="POST">
                    <button type="submit" name="clock_out">Clock Out</button>
                </form>
            </div>

            <div class="card">
                <h3>Latest Status</h3>
                <?php if ($latest): ?>
                    <p>Clock In: <?php echo htmlspecialchars($latest["clock_in"] ?? "-"); ?></p>
                    <p>Clock Out: <?php echo htmlspecialchars($latest["clock_out"] ?? "Still clocked in"); ?></p>
                    <p>Total Hours: <?php echo htmlspecialchars($latest["total_hours"] ?? "0"); ?></p>
                <?php else: ?>
                    <p>No attendance record yet.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>
</div>

</body>
</html>