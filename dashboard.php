<?php
session_start();
require_once 'middleware/auth.php';
require_once 'conn.php';

$user_role = $_SESSION['role'];
$user_name = $_SESSION['name'];

$students = [];

if ($user_role === 'faculty') {
    $stmt = $pdo->query("SELECT id, name, email FROM students");
    $students = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Student Management System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'layout/header.php'; ?>
    
    <div class="container">
        <div class="dashboard">
            <h1>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h1>
            
            <?php if ($user_role === 'faculty'): ?>
                <div class="faculty-dashboard">
                    <h2>Faculty Dashboard</h2>
                    <div class="actions">
                        <a href="dashboard/faculty/add-student.php" class="btn btn-primary">Add Student</a>
                        <a href="dashboard/faculty/update-student.php" class="btn btn-info">Update Student</a>
                        <a href="dashboard/faculty/delete-student.php" class="btn btn-danger">Delete Student</a>
                    </div>

                    <h3>Student List</h3>
                    <table class="table" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid #ccc; padding: 8px;">ID</th>
                                <th style="border: 1px solid #ccc; padding: 8px;">Name</th>
                                <th style="border: 1px solid #ccc; padding: 8px;">Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($students): ?>
                                <?php foreach ($students as $student): ?>
                                    <tr>
                                        <td style="border: 1px solid #ccc; padding: 8px;"><?php echo htmlspecialchars($student['id']); ?></td>
                                        <td style="border: 1px solid #ccc; padding: 8px;"><?php echo htmlspecialchars($student['name']); ?></td>
                                        <td style="border: 1px solid #ccc; padding: 8px;"><?php echo htmlspecialchars($student['email']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="3" style="padding: 8px;">No students found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="student-dashboard container">
                <h2 class="dashboard-title">Student Dashboard</h2>

                <div class="dashboard-actions">
                    <a href="dashboard/student/view-account.php" class="btn btn-primary">View My Account</a>
                </div>
            </div>

            <?php endif; ?> 
        </div>
    </div>
    
    <?php include 'layout/footer.php'; ?>
    <script src="assets/js/script.js"></script>
</body>
</html>
