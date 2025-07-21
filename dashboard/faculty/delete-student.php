<?php
session_start();
require_once '../../middleware/auth.php';
require_once '../../middleware/role-check.php';
require_once '../../conn.php';

checkRole('faculty');

$success = '';
$error = '';

if (isset($_GET['delete']) && $_GET['delete']) {
    $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
    if ($stmt->execute([$_GET['delete']])) {
        $success = 'Student deleted successfully!';
    } else {
        $error = 'Error deleting student';
    }
}

$stmt = $pdo->query("SELECT * FROM students ORDER BY name");
$students = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Student - Student Management System</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../layout/header.php'; ?>
    
    <div class="container">
        <div class="hero">
            <h2>Delete Student</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <div style="max-width: 800px; margin: 0 auto;">
                <?php if (empty($students)): ?>
                    <p>No students found.</p>
                <?php else: ?>
                    <?php foreach ($students as $student): ?>
                        <div style="border: 1px solid #ddd; padding: 15px; margin: 10px 0; border-radius: 5px; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <strong><?php echo htmlspecialchars($student['name']); ?></strong> (<?php echo htmlspecialchars($student['student_id']); ?>)
                                <br>
                                <small><?php echo htmlspecialchars($student['email']); ?></small>
                                <br>
                                <small><?php echo htmlspecialchars($student['course']); ?> - <?php echo htmlspecialchars($student['year_level']); ?>th Year</small>
                            </div>
                            <div>
                                <a href="?delete=<?php echo $student['id']; ?>" 
                                   class="btn btn-danger" 
                                   onclick="return confirmDelete()">Delete</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <div style="margin-top: 20px;">
                <a href="../../dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
            </div>
        </div>
    </div>
    
    <?php include '../../layout/footer.php'; ?>
    <script src="../../assets/js/script.js"></script>
</body>
</html>