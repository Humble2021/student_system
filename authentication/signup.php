<?php
session_start();
require_once '../conn.php';

$error = '';
$success = '';

if ($_POST) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    if ($role === 'student') {
        $course = $_POST['course'];
        $year_level = $_POST['year_level'];

        $stmt = $pdo->prepare("SELECT * FROM students WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $error = 'Email already exists as a student';
        } else {
            $student_id = '2024-' . rand(100, 999);

            $stmt = $pdo->prepare("INSERT INTO students (student_id, name, email, password, course, year_level)
                                   VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$student_id, $name, $email, $password, $course, $year_level])) {
                $success = 'Student account created successfully!';
            } else {
                $error = 'Error creating student account';
            }
        }

    } elseif ($role === 'faculty') {
        $department = $_POST['department'];
        $position = $_POST['position'];

        $stmt = $pdo->prepare("SELECT * FROM faculty WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $error = 'Email already exists as a faculty';
        } else {
            $faculty_id = 'FAC-' . rand(100, 999);

            $stmt = $pdo->prepare("INSERT INTO faculty (faculty_id, name, email, password, department, position)
                                   VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$faculty_id, $name, $email, $password, $department, $position])) {
                $success = 'Faculty account created successfully!';
            } else {
                $error = 'Error creating faculty account';
            }
        }

    } else {
        $error = 'Invalid role selected.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up - Student Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script>
        function toggleFields() {
            const role = document.querySelector('[name="role"]').value;
            document.getElementById('student-fields').style.display = role === 'student' ? 'block' : 'none';
            document.getElementById('faculty-fields').style.display = role === 'faculty' ? 'block' : 'none';
        }
    </script>
</head>
<body>
<?php include '../layout/header.php'; ?>

<div class="container">
    <div class="hero">
        <h2>Sign Up</h2>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <form method="POST" style="max-width: 500px; margin: auto;">
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
                <label>Role:</label>
                <select name="role" onchange="toggleFields()" required>
                    <option value="">Select Role</option>
                    <option value="student">Student</option>
                    <option value="faculty">Faculty</option>
                </select>
            </div>

            <div id="student-fields" style="display: none;">
                <div class="form-group">
                    <label>Course:</label>
                    <input type="text" name="course">
                </div>
                <div class="form-group">
                <label>Year Level:</label>
                <select name="year_level" onchange="toggleFields()" required>
                    <option value="">Select Year Level</option>
                    <option value="1">1st Year</option>
                    <option value="2">2nd Year</option>
                    <option value="3">3rd Year</option>
                    <option value="4">4th Year</option>
                </select>
            </div>
            </div>

            <div id="faculty-fields" style="display: none;">
                <div class="form-group">
                    <label>Department:</label>
                    <input type="text" name="department">
                </div>
                <div class="form-group">
                    <label>Position:</label>
                    <input type="text" name="position">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>

        <p style="margin-top: 20px;">
            Already have an account? <a href="login.php">Login here</a>
        </p>
    </div>
</div>

<?php include '../layout/footer.php'; ?>
</body>
</html>
