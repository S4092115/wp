<?php
// Include the header and the database connection
include_once "includes/header.inc";
include_once "includes/db_connect.inc"; 

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
    $sql = "SELECT petid, petname, image, description FROM pets WHERE userID = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $userID);
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
            <?php include_once "includes/nav.inc"; ?>
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
                    echo '<h2>' . htmlspecialchars($row['petname']) . '</h2>';
                    echo '<p>' . htmlspecialchars($row['description']) . '</p>';
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
