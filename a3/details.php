<?php
session_start(); // Start session to access the logged-in user details
include_once "includes/header.inc";
include_once "includes/db_connect.inc";

// Get the pet ID from the query string
if (isset($_GET['petid'])) {
    $petid = intval($_GET['petid']);  // Make sure 'petid' is an integer

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
            echo "<div class='alert alert-danger'>Sorry, no pet found with the specified ID.</div>";
            exit();
        }
    } else {
        echo "<div class='alert alert-danger'>Error retrieving pet details: " . $conn->error . "</div>";
        exit();
    }

    $stmt->close();
} else {
    echo "<div class='alert alert-danger'>No pet selected. Please go back and select a pet.</div>";
    exit();
}
?>

<body>
    <div class="container mt-5">
        <div class="text-center mb-4">
            <h1 class="display-4"><?php echo htmlspecialchars($row['petname']); ?></h1>
        </div>
        <div class="row">
            <div class="col-md-6">
                <img src="images/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['petname']); ?>" class="img-fluid rounded shadow">
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <h2><?php echo htmlspecialchars($row['caption']); ?></h2>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                </div>
                <ul class="list-group mb-3">
                    <li class="list-group-item">
                        <strong>Age:</strong> 
                        <?php echo ($row['age'] < 12) ? htmlspecialchars($row['age']) . " months" : round(htmlspecialchars($row['age']) / 12, 1) . " years"; ?>
                    </li>
                    <li class="list-group-item"><strong>Type:</strong> <?php echo htmlspecialchars($row['type']); ?></li>
                    <li class="list-group-item"><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></li>
                </ul>
                <?php if (isset($_SESSION['username']) && $_SESSION['username'] == $row['username']) : ?>
                    <div class="d-flex gap-2">
                        <a href="edit.php?petid=<?php echo $petid; ?>" class="btn btn-primary">Edit</a>
                        <a href="delete.php?petid=<?php echo $petid; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this pet?');">Delete</a>
                    </div>
                <?php elseif (isset($_SESSION['username'])): ?>
                    <div class="alert alert-warning mt-3">You do not have permission to edit or delete this pet.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include_once "includes/footer.inc"; ?>
</body>
