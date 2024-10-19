<?php include_once "includes/header.inc"; ?>
<?php include_once "includes/db_connect.inc"; ?>

<?php
// Check if session has started before starting it again
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = sha1($_POST['password']);  //hashes the password
    
    // Prepare and execute query
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // If login is successful, create a session
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit(); // Make sure the script stops after redirection
    } else {
        echo "<p style='color: red;'>Invalid login details. Please try again.</p>";
    }
    
    $stmt->close();
}
?>

<body>
    <div class="wrapper">
        <header>
            <?php include_once "includes/nav.inc"; ?>
        </header>
        <h2>Login</h2>
        <form method="POST">
            <label>Username:</label>
            <input type="text" name="username" required><br>
            <label>Password:</label>
            <input type="password" name="password" required><br>
            <button type="submit">Login</button>
        </form>
    </div>
    <?php include_once "includes/footer.inc"; ?>
</body>
</html>
