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
        $imageCaption = $_POST['caption'];  // New field for the image caption
        $newImageName = $pet['image']; // Set default to the existing image name

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
                if ($imageSize < 500000) { // Ensure image size is less than 500KB
                    // Generate a unique name for the new image
                    $newImageName = uniqid("", true) . "." . $imageExt;
                    $imageDestination = "images/" . $newImageName;

                    // Move the uploaded image to the 'images' directory
                    if (move_uploaded_file($imageTmpName, $imageDestination)) {
                        // Delete the old image file if a new one is uploaded
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
    <div class="wrapper">
        <header>
            <?php include_once "includes/nav.inc"; ?>
        </header>
        <h2>Edit Pet</h2>

        <form action="edit.php?petid=<?php echo $petid; ?>" method="POST" enctype="multipart/form-data">
            <label for="pet-name">Pet Name:</label>
            <input type="text" id="pet-name" name="petname" value="<?php echo htmlspecialchars($pet['petname']); ?>" required>

            <label for="pet-type">Type:</label>
            <select id="pet-type" name="pettype" required>
                <option value="" disabled>--Choose an option--</option>
                <option value="Dog" <?php if ($pet['type'] == 'Dog') echo 'selected'; ?>>Dog</option>
                <option value="Cat" <?php if ($pet['type'] == 'Cat') echo 'selected'; ?>>Cat</option>
                <option value="Bird" <?php if ($pet['type'] == 'Bird') echo 'selected'; ?>>Bird</option>
                <option value="Other" <?php if ($pet['type'] == 'Other') echo 'selected'; ?>>Other</option>
            </select>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($pet['description']); ?></textarea>

            <label for="caption">Image Caption:</label> <!-- New input for the image caption -->
            <input type="text" id="caption" name="caption" value="<?php echo htmlspecialchars($pet['caption']); ?>" required>

            <label for="pet-age">Age (months):</label>
            <input type="number" id="pet-age" name="age" value="<?php echo htmlspecialchars($pet['age']); ?>" required>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($pet['location']); ?>" required>

            <label for="image">Current Image:</label>
            <img src="images/<?php echo $pet['image']; ?>" alt="Current Pet Image" style="max-width: 200px; display: block;">

            <label for="image">Replace Image (optional):</label>
            <input type="file" name="image">

            <input type="submit" value="Update Pet">
            <button type="reset">Clear</button>
        </form>
    </div>
    <?php include_once "includes/footer.inc"; ?>
</body>
</html>
