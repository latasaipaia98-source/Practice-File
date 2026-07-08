<?php
session_start();

if (!isset($_SESSION["employee_id"])) {
    header("Location: login.php");
    exit;
}

$name = $_SESSION["name"] ?? "Employee";
$employee_id = $_SESSION["employee_id"] ?? "";
$role = $_SESSION["role"] ?? "employee";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Workday Lite Dashboard</title>
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
            <h1>Welcome, <?php echo htmlspecialchars($name); ?> 👋</h1>
            <p>Employee ID: <?php echo htmlspecialchars($employee_id); ?> | Role: <?php echo htmlspecialchars($role); ?></p>
        </header>

        <section class="cards">
            <div class="card">
                <h3>Today’s Status</h3>
                <p>Not clocked in yet</p>
                <button>Clock In</button>
            </div>

            <div class="card">
                <h3>Hours Today</h3>
                <p class="big">0.00 hrs</p>
            </div>

            <div class="card">
                <h3>Leave Balance</h3>
                <p class="big">10 days</p>
            </div>
        </section>

        <section class="table-section">
            <h2>Recent Timesheet</h2>

            <table>
                <tr>
                    <th>Date</th>
                    <th>Clock In</th>
                    <th>Clock Out</th>
                    <th>Total Hours</th>
                </tr>
                <tr>
                    <td>Today</td>
                    <td>-</td>
                    <td>-</td>
                    <td>0.00</td>
                </tr>
            </table>
        </section>
    </main>
</div>

</body>
</html>