<?php
session_start();
require_once '../../middleware/auth.php';
require_once '../../middleware/role-check.php';
require_once '../../conn.php';

checkRole('faculty');

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = trim($_POST['student_id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $course = trim($_POST['course']);
    $year_level = $_POST['year_level'];
    $password = trim($_POST['password']);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if (!$student_id || !$name || !$email || !$course || !$year_level || !$password) {
        $error = 'All fields are required.';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT 1 FROM students WHERE student_id = ?");
            $stmt->execute([$student_id]);

            if ($stmt->fetch()) {
                $error = 'Student ID already exists.';
            } else {
                $stmt = $pdo->prepare("INSERT INTO students (student_id, name, email, password, course, year_level) VALUES (?, ?, ?, ?, ?, ?)");
                if ($stmt->execute([$student_id, $name, $email, $hashedPassword, $course, $year_level])) {
                    $success = 'Student added successfully!';
                } else {
                    $error = 'Failed to add student. Please try again.';
                }
            }
        } catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student - Student Management System</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
<?php include '../../layout/header.php'; ?>

<div class="container">
    <div class="hero">
        <h2>Add New Student</h2>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST" style="max-width: 500px; margin: 0 auto;">
            <div class="form-group">
                <label>Student ID:</label>
                <input type="text" name="student_id" required>
            </div>

            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" required>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-group">
                <label>Course:</label>
                <input type="text" name="course" required>
            </div>

            <div class="form-group">
                <label>Year Level:</label>
                <select name="year_level" required>
                    <option value="">Select Year</option>
                    <option value="1">1st Year</option>
                    <option value="2">2nd Year</option>
                    <option value="3">3rd Year</option>
                    <option value="4">4th Year</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Add Student</button>
            <a href="../../dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </form>
    </div>
</div>

<?php include '../../layout/footer.php'; ?>
</body>
</html>
