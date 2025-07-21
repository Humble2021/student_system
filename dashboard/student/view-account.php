<?php
session_start();
require_once '../../middleware/auth.php';
require_once '../../middleware/role-check.php';
require_once '../../conn.php';

checkRole('student');

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$user_id]);
$student = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - Student Management System</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../layout/header.php'; ?>
    
    <div class="container">
        <div class="hero">
            <h2>My Account</h2>
            
            <div style="max-width: 600px; margin: 0 auto; text-align: left;">
                <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                    <h3>Account Information</h3>
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($student['name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($student['email']); ?></p>
                    <p><strong>Role:</strong> Student</p>
                    <p><strong>Account Created:</strong> <?php echo date('F j, Y', strtotime($student['created_at'])); ?></p>
                </div>

                <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-top: 20px;">
                    <h3>Student Details</h3>
                    <p><strong>Student ID:</strong> <?php echo htmlspecialchars($student['student_id']); ?></p>
                    <p><strong>Course:</strong> <?php echo htmlspecialchars($student['course']); ?></p>
                    <p><strong>Year Level:</strong> <?php echo htmlspecialchars($student['year_level']); ?>th Year</p>
                </div>
            </div>
            
            <div style="margin-top: 20px;">
                <a href="../../dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
            </div>
        </div>
    </div>
    
    <?php include '../../layout/footer.php'; ?>
</body>
</html>
