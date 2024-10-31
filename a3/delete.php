<?php 
include_once "includes/header.inc"; 
include_once "includes/db_connect.inc"; 

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if the pet ID is provided
if (isset($_GET['petid'])) {
    $petid = intval($_GET['petid']);
    
    // Fetch the pet details including the image
    $sql = "SELECT image FROM pets WHERE petid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $petid);
    $stmt->execute();
    $result = $stmt->get_result();
    $pet = $result->fetch_assoc();

    if (!$pet) {
        echo "<div class='alert alert-danger'>Pet not found.</div>";
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Prepare to delete the pet record
        $sql = "DELETE FROM pets WHERE petid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $petid);
        
        if ($stmt->execute()) {
            // Deletes the associated image
            $imagePath = "images/" . $pet['image'];
            if (file_exists($imagePath) && $imagePath != "images/default.jpg") {
                unlink($imagePath); // Delete the image
            }
            // Redirect to the gallery page after successful deletion
            header("Location: gallery.php");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    }
}
?>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Delete Pet</h2>
        <p class="text-center">Are you sure you want to delete this pet?</p>
        <div class="d-flex justify-content-center">
            <form method="POST" onsubmit="return confirmDeletion();" class="text-center">
                <button type="submit" class="btn btn-danger me-3">Yes, Delete</button>
                <a href="details.php?petid=<?php echo $petid; ?>" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
    
    <?php include_once "includes/footer.inc"; ?>

    <script>
        function confirmDeletion() {
            return confirm('Are you sure you want to delete this pet? This action cannot be undone.');
        }
    </script>
</body>
</html>
