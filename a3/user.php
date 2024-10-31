<?php
// Include the header and the database connection
include_once "includes/header.inc";
include_once "includes/db_connect.inc";

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if userID is present in the query string
if (isset($_GET['userID'])) {
    $userID = intval($_GET['userID']); // Ensure the userID is an integer

    // Fetch the username of the user
    $userSql = "SELECT username FROM users WHERE userID = ?";
    if ($stmt = $conn->prepare($userSql)) {
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $stmt->bind_result($username);
        $stmt->fetch();
        $stmt->close();
    } else {
        echo "Error fetching username: " . $conn->error;
        exit;
    }

    // Fetch all pets uploaded by this user
    $sql = "SELECT petid, petname, image, description FROM pets WHERE username = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $username); // Use the username
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        echo "Error fetching pets: " . $conn->error;
        exit;
    }
} else {
    echo "No user selected.";
    exit;
}
?>

<body>
    <div class="wrapper">
        <header>
            <a href="index.php">
                <img src="images/logo.png" alt="Pets Victoria Logo" class="logo">
            </a>
        </header>

        <main class="main-content">
            <h1>Pets uploaded by <?php echo htmlspecialchars($username); ?></h1>

            <?php
            // Check if any pets were found for this user
            if ($result->num_rows > 0) {
                echo '<div class="pets-container">';
                // Loop through all the pets and display them
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="pet-card">';
                    echo '<img src="images/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['petname']) . '">';
                    
                    // Link to the pet details page
                    echo '<h2><a href="details.php?petid=' . htmlspecialchars($row['petid']) . '">' . htmlspecialchars($row['petname']) . '</a></h2>';
                    echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                    
                    // If the logged-in user is the owner, show edit/delete options
                    if (isset($_SESSION['username']) && $_SESSION['username'] == $username) {
                        echo '<div class="pet-actions">';
                        echo '<a href="edit.php?petid=' . htmlspecialchars($row['petid']) . '" class="btn btn-primary">Edit</a>';
                        echo '<a href="delete.php?petid=' . htmlspecialchars($row['petid']) . '" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to delete this pet?\');">Delete</a>';
                        echo '</div>';
                    }
                    
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo "<p>No pets uploaded by this user yet.</p>";
            }
            ?>
        </main>

        <?php include_once "includes/footer.inc"; ?>
    </div>
</body>
</html>
