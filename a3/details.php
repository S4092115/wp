<?php
session_start(); // Start session to access the logged-in user details
include_once "includes/header.inc";
include_once "includes/db_connect.inc";

// Get the pet ID from the query string
if (isset($_GET['id'])) {
    $petid = intval($_GET['id']);

    // Prepare a SQL query to fetch the pet's details
    $sql = "SELECT petname, type, age, location, image, caption, description, username FROM pets WHERE petid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $petid);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        // Check if a pet with the given ID exists
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc(); // Fetch the pet details
        } else {
            echo "<p>Sorry, no pet found with the specified ID.</p>";
            exit();
        }
    } else {
        echo "<p>Error retrieving pet details: " . $conn->error . "</p>";
        exit();
    }

    $stmt->close();
} else {
    echo "<p>No pet selected. Please go back and select a pet.</p>";
    exit();
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

        <div class="main-content">
            <h1><?php echo $row['petname']; ?></h1>
            <div class="pet-details">
                <img src="images/<?php echo $row['image']; ?>" alt="<?php echo $row['petname']; ?>" class="pet-image">

                <div class="pet-info-icons">
                    <div>
                        <i class="material-icons">Age</i>
                        <span><?php echo ($row['age'] < 12) ? $row['age'] . " months" : round($row['age'] / 12, 1) . " years"; ?></span>
                    </div>
                    <div>
                        <i class="material-icons">Pet type</i>
                        <span><?php echo $row['type']; ?></span>
                    </div>
                    <div>
                        <i class="material-icons">Place</i>
                        <span><?php echo $row['location']; ?></span>
                    </div>
                </div>
                <div class="pet-description">
                    <h2><?php echo $row['caption']; ?></h2>
                    <p><?php echo $row['description']; ?></p>
                </div>
            </div>

            <!-- Show Edit/Delete buttons if the logged-in user is the owner of the pet -->
            <?php if (isset($_SESSION['username']) && $_SESSION['username'] == $row['username']) : ?>
                <div class="edit-delete-buttons">
                    <a href="edit.php?petid=<?php echo $petid; ?>" class="btn btn-primary">Edit</a>
                    <a href="delete.php?petid=<?php echo $petid; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this pet?');">Delete</a>
                </div>
            <?php endif; ?>
        </div>

        <?php include_once "includes/footer.inc"; ?>
    </div>
</body>
</html>
