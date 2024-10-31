<?php include_once "includes/header.inc"; ?>
<?php include_once "includes/db_connect.inc"; ?>

<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Display success message if account was created
if (isset($_SESSION['success_message'])) {
    echo '<div class="alert alert-success text-center">' . $_SESSION['success_message'] . '</div>';
    unset($_SESSION['success_message']); // Clear message after displaying it
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = sha1($_POST['password']);  // Hash the password
    
    // Prepare and execute query
    $sql = "SELECT userID, username FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Fetch the user data
        $user = $result->fetch_assoc();
        
        // If login is successful, create a session
        $_SESSION['username'] = $user['username'];
        $_SESSION['userID'] = $user['userID']; // Store userID in the session
        
        // Redirect to the user's profile page
        header("Location: user.php?userID=" . $user['userID']);
        exit(); // Ensure the script stops after redirection
    } else {
        echo "<div class='alert alert-danger text-center'>Invalid login details. Please try again.</div>";
    }
    
    $stmt->close();
}
?>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Login</h2>
        
        <form method="POST" class="mx-auto" style="max-width: 400px;">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
    
    <?php include_once "includes/footer.inc"; ?>
</body>
</html>
