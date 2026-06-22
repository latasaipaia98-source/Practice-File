<?php
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $employee_id = $_POST["employee_id"] ?? "";
    $password = $_POST["password"] ?? "";

    // Temporary test login
    if ($employee_id === "12345" && $password === "password") {
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid Employee ID or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Workday Lite Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

<div class="login-page">

    <div class="left-panel">
        <h1>Workday <span>Lite</span></h1>
        <h2>Welcome back!</h2>
        <p>Sign in to access your dashboard, manage attendance, leaves, and more.</p>

        <div class="features">
            <div>🔒 Secure</div>
            <div>⏰ Reliable</div>
            <div>👥 Connected</div>
        </div>
    </div>

    <div class="right-panel">
        <form method="POST" action="login.php" class="login-box">
            <h2>Sign in to your account</h2>
            <p>Please enter your credentials to continue</p>

            <?php if ($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>

            <label>Employee ID</label>
            <input type="text" name="employee_id" placeholder="Enter your employee ID" required>

            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your password" required>

            <div class="row">
                <label class="remember">
                    <input type="checkbox"> Remember me
                </label>
                <a href="#">Forgot password?</a>
            </div>

            <button type="submit">Sign In</button>

            <p class="support">Need help? Contact <a href="#">IT Support</a></p>
        </form>
    </div>

</div>

</body>
</html>