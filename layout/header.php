<header class="header">
    <div class="container">
        <nav class="nav">
            <div class="logo">Student System</div>
            <div class="nav-links">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/dashboard.php">Dashboard</a>
                    <span>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></span>
                    <a href="/authentication/logout.php">Logout</a>
                <?php else: ?>
                    <a href="/index.php">Home</a>
                    <a href="/authentication/login.php">Login</a>
                    <a href="/authentication/signup.php">Sign Up</a>
                <?php endif; ?>
            </div>
        </nav>
    </div>
</header>
