<?php include_once "includes/header.inc"; ?>
<?php include_once "includes/db_connect.inc"; ?>

<?php
// Only allow logged-in users to access this page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['petid'])) {
    $petid = $_GET['petid'];

    // Fetch the pet details from the database
    $sql = "SELECT * FROM pets WHERE petid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $petid);
    $stmt->execute();
    $result = $stmt->get_result();
    $pet = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $petname = $_POST['petname'];
        $type = $_POST['pettype'];
        $age = $_POST['age'];
        $location = $_POST['location'];
        $description = $_POST['description'];
        $imageCaption = $_POST['caption'];
        $newImageName = $pet['image'];

        // Handle new image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image = $_FILES['image'];
            $imageTmpName = $image['tmp_name'];
            $imageName = $image['name'];
            $imageSize = $image['size'];
            $imageError = $image['error'];
            $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
            $allowed = array("jpg", "jpeg", "png");

            if (in_array($imageExt, $allowed)) {
                if ($imageSize < 500000) {
                    $newImageName = uniqid("", true) . "." . $imageExt;
                    $imageDestination = "images/" . $newImageName;

                    // Move the uploaded image and delete the old one if applicable
                    if (move_uploaded_file($imageTmpName, $imageDestination)) {
                        $oldImagePath = "images/" . $pet['image'];
                        if (file_exists($oldImagePath) && $oldImagePath != "images/default.jpg") {
                            unlink($oldImagePath);
                        }
                    } else {
                        echo "Failed to upload the new image.";
                    }
                } else {
                    echo "File size too big! Maximum allowed size is 500KB.";
                }
            } else {
                echo "Invalid file type! Only JPG, JPEG, and PNG are allowed.";
            }
        }

        // Update the pet information, including the image and image caption
        $sql = "UPDATE pets SET petname = ?, type = ?, age = ?, location = ?, description = ?, caption = ?, image = ? WHERE petid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssissssi", $petname, $type, $age, $location, $description, $imageCaption, $newImageName, $petid);

        if ($stmt->execute()) {
            // Redirect to gallery.php after successful update
            header("Location: gallery.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Edit Pet</h2>

        <form action="edit.php?petid=<?php echo $petid; ?>" method="POST" enctype="multipart/form-data" class="mx-auto" style="max-width: 600px;">
            <div class="mb-3">
                <label for="pet-name" class="form-label">Pet Name:</label>
                <input type="text" id="pet-name" name="petname" class="form-control" value="<?php echo htmlspecialchars($pet['petname']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="pet-type" class="form-label">Type:</label>
                <select id="pet-type" name="pettype" class="form-select" required>
                    <option value="" disabled>--Choose an option--</option>
                    <option value="Dog" <?php if ($pet['type'] == 'Dog') echo 'selected'; ?>>Dog</option>
                    <option value="Cat" <?php if ($pet['type'] == 'Cat') echo 'selected'; ?>>Cat</option>
                    <option value="Bird" <?php if ($pet['type'] == 'Bird') echo 'selected'; ?>>Bird</option>
                    <option value="Other" <?php if ($pet['type'] == 'Other') echo 'selected'; ?>>Other</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea id="description" name="description" class="form-control" required><?php echo htmlspecialchars($pet['description']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="caption" class="form-label">Image Caption:</label>
                <input type="text" id="caption" name="caption" class="form-control" value="<?php echo htmlspecialchars($pet['caption']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="pet-age" class="form-label">Age (months):</label>
                <input type="number" id="pet-age" name="age" class="form-control" value="<?php echo htmlspecialchars($pet['age']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="location" class="form-label">Location:</label>
                <input type="text" id="location" name="location" class="form-control" value="<?php echo htmlspecialchars($pet['location']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Current Image:</label>
                <div>
                    <img src="images/<?php echo htmlspecialchars($pet['image']); ?>" alt="Current Pet Image" class="img-fluid mb-3" style="max-width: 200px;">
                </div>
                <label for="image" class="form-label">Replace Image (optional):</label>
                <input type="file" name="image" class="form-control">
                <small class="form-text text-muted">Max size: 500KB. Allowed types: JPG, JPEG, PNG.</small>
            </div>

            <button type="submit" class="btn btn-primary w-100">Update Pet</button>
            <button type="reset" class="btn btn-secondary w-100 mt-2">Clear</button>
        </form>
    </div>
    
    <?php include_once "includes/footer.inc"; ?>
</body>
</html>
