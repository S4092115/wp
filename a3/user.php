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
    <div class="container py-5">
        <h1 class="text-center mb-4">Pets uploaded by <?php echo htmlspecialchars($username); ?></h1>

        <?php
        // Check if any pets were found for this user
        if ($result->num_rows > 0) {
            echo '<div class="row g-4">';
            // Loop through all the pets and display them
            while ($row = $result->fetch_assoc()) {
                echo '<div class="col-sm-6 col-md-4 col-lg-3">';
                echo '<div class="card h-100 shadow-sm">';

                // Pet Image
                echo '<img src="images/' . htmlspecialchars($row['image']) . '" class="card-img-top" alt="' . htmlspecialchars($row['petname']) . '" style="height: 200px; object-fit: cover;">';

                // Pet Info
                echo '<div class="card-body">';
                echo '<h5 class="card-title"><a href="details.php?petid=' . htmlspecialchars($row['petid']) . '" class="text-decoration-none text-dark">' . htmlspecialchars($row['petname']) . '</a></h5>';
                echo '<p class="card-text">' . htmlspecialchars($row['description']) . '</p>';
                echo '</div>';

                // Edit/Delete Options for Owner
                if (isset($_SESSION['username']) && $_SESSION['username'] == $username) {
                    echo '<div class="card-footer d-flex justify-content-between">';
                    echo '<a href="edit.php?petid=' . htmlspecialchars($row['petid']) . '" class="btn btn-primary btn-sm">Edit</a>';
                    echo '<a href="delete.php?petid=' . htmlspecialchars($row['petid']) . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this pet?\');">Delete</a>';
                    echo '</div>';
                }

                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo "<p class='text-center'>No pets uploaded by this user yet.</p>";
        }
        ?>
    </div>

    <?php include_once "includes/footer.inc"; ?>
</body>
</html>
