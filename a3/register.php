<?php include_once "includes/header.inc"; ?>
<?php include_once "includes/db_connect.inc"; ?>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Encrypt the password using SHA encryption
    $hashed_password = sha1($password);
    
    // Insert the new user into the database
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $hashed_password);
    
    if ($stmt->execute()) {
        header("Location: login.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
    $stmt->close();
}
?>

<body>
        <h2 class="text-center mb-4">Register</h2>
        
        <form method="POST" class="mx-auto" style="max-width: 500px;">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
    </div>
    <?php include_once "includes/footer.inc"; ?>
</body>
</html>
