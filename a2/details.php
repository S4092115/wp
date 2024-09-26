<?php include_once "includes/header.inc"; ?>
<?php include_once "includes/db_connect.inc"; ?>

<?php
// Get the pet ID from the query string
if (isset($_GET['id'])) {
    $petid = intval($_GET['id']);

    // Prepare a SQL query to fetch the pet's details
    $sql = "SELECT petname, type, age, location, image, caption, description FROM pets WHERE petid = ?";
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
            <select id="pageSelect">
                <option value="" disabled selected>Select an Option...</option>
                <option value="index.php">Home</option>
                <option value="pets.php">Pets</option>
                <option value="add.php">Add A Pet</option>
                <option value="gallery.php">Gallery</option>
            </select>
            <input type="search" placeholder="Search">
            <img src="images/searchico.png" alt="Search Icon" class="search-icon">
        </header>

        <div class="main-content">
            <h1><?php echo $row['petname']; ?></h1>
            <div class="pet-details">
                <!-- Pet image -->
                <img src="images/<?php echo $row['image']; ?>" alt="<?php echo $row['petname']; ?>" class="pet-image">

                <!-- Pet information: Age, Type, Location -->
                <div class="pet-info-icons">
                    <div>
                        <i class="material-icons">schedule</i>
                        <span><?php echo ($row['age'] < 12) ? $row['age'] . " months" : round($row['age'] / 12, 1) . " years"; ?></span>
                    </div>
                    <div>
                        <i class="material-icons">pets</i>
                        <span><?php echo $row['type']; ?></span>
                    </div>
                    <div>
                        <i class="material-icons">place</i>
                        <span><?php echo $row['location']; ?></span>
                    </div>
                </div>

                <!-- Pet description and caption -->
                <div class="pet-description">
                    <h2><?php echo $row['caption']; ?></h2>
                    <p><?php echo $row['description']; ?></p>
                </div>
            </div>
        </div>

        <?php include_once "includes/footer.inc"; ?>
    </div>
</body>
</html>

