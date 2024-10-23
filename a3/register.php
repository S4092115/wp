<?php include_once "includes/header.inc"; ?>
<?php include_once "includes/db_connect.inc"; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Grab the form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Encrypt the password using SHA encryption
    $hashed_password = sha1($password);
    
    // Insert the new user into the database
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $hashed_password);
    
    if ($stmt->execute()) {
        echo "Registration successful!";
        header("Location: login.php");
    } else {
        echo "Error: " . $conn->error;
    }
    
    $stmt->close();
}
?>

<body>
    <div class="wrapper">
        <header>
            <?php include_once "includes/nav.inc"; ?>
        </header>
        <h2>Register</h2>
        <form method="POST">
            <label>Username:</label>
            <input type="text" name="username" required><br>
            <label>Password:</label>
            <input type="password" name="password" required><br>
            <button type="submit">Register</button>
        </form>
    </div>
    <?php include_once "includes/footer.inc"; ?>
</body>
</html>
