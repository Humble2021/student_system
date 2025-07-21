<?php
session_start();
require_once '../conn.php';

$error = '';

if ($_POST) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM faculty WHERE email = ?");
    $stmt->execute([$email]);
    $faculty = $stmt->fetch();

    if ($faculty && password_verify($password, $faculty['password'])) {
        $_SESSION['user_id'] = $faculty['id'];
        $_SESSION['name'] = $faculty['name'];
        $_SESSION['email'] = $faculty['email'];
        $_SESSION['role'] = 'faculty';
        $_SESSION['position'] = $faculty['position'];
        $_SESSION['department'] = $faculty['department'];

        header('Location: ../dashboard.php');
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM students WHERE email = ?");
    $stmt->execute([$email]);
    $student = $stmt->fetch();

    if ($student && password_verify($password, $student['password'])) {
        $_SESSION['user_id'] = $student['id'];
        $_SESSION['name'] = $student['name'];
        $_SESSION['email'] = $student['email'];
        $_SESSION['role'] = 'student';
        $_SESSION['course'] = $student['course'];
        $_SESSION['year_level'] = $student['year_level'];

        header('Location: ../dashboard.php');
        exit();
    }

    $error = 'Invalid email or password';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Student Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php include '../layout/header.php'; ?>

<div class="container">
    <div class="hero">
        <h2>Login</h2>

        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" style="max-width: 400px; margin: auto;">
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
        </form>

        <p style="margin-top: 20px;">
            Don't have an account? <a href="signup.php">Sign up here</a>
        </p>
    </div>
</div>

<?php include '../layout/footer.php'; ?>
</body>
</html>
