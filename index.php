<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'layout/header.php'; ?>
    
    <div class="container">
        <div class="hero">
            <h1>Welcome to Student Management System</h1>
            <p>Manage student records efficiently and securely.</p>
            <div class="buttons">
                <a href="authentication/login.php" class="btn btn-primary">Login</a>
                <a href="authentication/signup.php" class="btn btn-secondary">Sign Up</a>
            </div>
        </div>
    </div>
    
    <?php include 'layout/footer.php'; ?>
    <script src="assets/js/script.js"></script>
</body>
</html>