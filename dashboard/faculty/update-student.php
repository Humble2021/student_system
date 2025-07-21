<?php
session_start();
require_once '../../middleware/auth.php';
require_once '../../middleware/role-check.php';
require_once '../../conn.php';

checkRole('faculty');

$success = '';
$error = '';
$student = null;

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $student = $stmt->fetch();
}

if ($_POST) {
    $id = $_POST['id'];
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $year_level = $_POST['year_level'];
    
    $stmt = $pdo->prepare("UPDATE students SET student_id = ?, name = ?, email = ?, course = ?, year_level = ? WHERE id = ?");
    
    if ($stmt->execute([$student_id, $name, $email, $course, $year_level, $id])) {
        $success = 'Student updated successfully!';
    } else {
        $error = 'Error updating student';
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
    <title>Update Student - Student Management System</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../layout/header.php'; ?>
    
    <div class="container">
        <div class="hero">
            <h2>Update Student</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if (!$student): ?>
                <h3>Select a student to update:</h3>
                <div style="max-width: 600px; margin: 0 auto;">
                    <?php foreach ($students as $s): ?>
                        <div style="border: 1px solid #ddd; padding: 10px; margin: 10px 0; border-radius: 5px;">
                            <strong><?php echo htmlspecialchars($s['name']); ?></strong> (<?php echo htmlspecialchars($s['student_id']); ?>)
                            <br>
                            <small><?php echo htmlspecialchars($s['course']); ?> - <?php echo htmlspecialchars($s['year_level']); ?>th Year</small>
                            <br>
                            <a href="?id=<?php echo $s['id']; ?>" class="btn btn-primary" style="margin-top: 5px;">Update</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <form method="POST" style="max-width: 500px; margin: 0 auto;">
                    <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
                    
                    <div class="form-group">
                        <label>Student ID:</label>
                        <input type="text" name="student_id" value="<?php echo htmlspecialchars($student['student_id']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Name:</label>
                        <input type="text" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Course:</label>
                        <input type="text" name="course" value="<?php echo htmlspecialchars($student['course']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Year Level:</label>
                        <select name="year_level" required>
                            <option value="1" <?php echo ($student['year_level'] == 1) ? 'selected' : ''; ?>>1st Year</option>
                            <option value="2" <?php echo ($student['year_level'] == 2) ? 'selected' : ''; ?>>2nd Year</option>
                            <option value="3" <?php echo ($student['year_level'] == 3) ? 'selected' : ''; ?>>3rd Year</option>
                            <option value="4" <?php echo ($student['year_level'] == 4) ? 'selected' : ''; ?>>4th Year</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update Student</button>
                    <a href="update-student.php" class="btn btn-secondary">Back to List</a>
                </form>
            <?php endif; ?>
            
            <div style="margin-top: 20px;">
                <a href="../../dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
            </div>
        </div>
    </div>
    
    <?php include '../../layout/footer.php'; ?>
</body>
</html>