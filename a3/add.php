<?php
session_start();
include_once "includes/header.inc";
include_once "includes/db_connect.inc";

// Ensure the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $petName = $_POST["petName"];
    $petType = $_POST["petType"];
    $description = $_POST["description"];
    $imageCaption = $_POST["imageCaption"];
    $petAge = $_POST["petAge"];
    $location = $_POST["location"];
    $image = $_FILES["image"];
    $username = $_SESSION['username'];

    $imageName = $image["name"];
    $imageTmpName = $image["tmp_name"];
    $imageSize = $image["size"];
    $imageError = $image["error"];
    $imageType = $image["type"];
    $imageExt = explode(".", $imageName);
    $imageActualExt = strtolower(end($imageExt));
    $allowed = array("jpg", "jpeg", "png");

    if (in_array($imageActualExt, $allowed)) {
        if ($imageError === 0) {
            if ($imageSize < 500000) { 
                $imageNewName = uniqid("", true) . "." . $imageActualExt;
                $imageDestination = "images/" . $imageNewName;
                move_uploaded_file($imageTmpName, $imageDestination);

                $sql = "INSERT INTO pets (petname, type, description, caption, age, location, image, username) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "SQL Error: " . mysqli_error($conn);
                } else {
                    mysqli_stmt_bind_param($stmt, "ssssisss", $petName, $petType, $description, $imageCaption, $petAge, $location, $imageNewName, $username);
                    if (mysqli_stmt_execute($stmt)) {
                        header("Location: pets.php?success");
                        exit();
                    } else {
                        echo "Error executing SQL: " . mysqli_error($conn);
                    }
                }
            } else {
                echo "File size too big! Maximum allowed size is 500KB.";
            }
        } else {
            echo "Error uploading file!";
        }
    } else {
        echo "Invalid file type! Only JPG, JPEG, and PNG are allowed.";
    }
}
?>

<body>
    <div class="container py-5">
        <h1 class="text-center mb-4">Add a New Pet</h1>
        <form action="add.php" method="POST" enctype="multipart/form-data" class="row g-3">
            
            <div class="col-md-6">
                <label for="pet-name" class="form-label">Provide a name for the pet:</label>
                <input type="text" id="pet-name" name="petName" class="form-control" required>
            </div>
            
            <div class="col-md-6">
                <label for="pet-type" class="form-label">Type:</label>
                <select id="pet-type" name="petType" class="form-select" required>
                    <option value="" disabled selected>--Choose an option--</option>
                    <option value="Dog">Dog</option>
                    <option value="Cat">Cat</option>
                    <option value="Bird">Bird</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            
            <div class="col-12">
                <label for="description" class="form-label">Description:</label>
                <textarea id="description" name="description" class="form-control" rows="3" required></textarea>
            </div>
            
            <div class="col-12">
                <label for="image" class="form-label">Select an Image: <span style="color: red;">MAX IMAGE SIZE: 500KB</span></label>
                <input type="file" id="image" name="image" class="form-control" required>
            </div>
            
            <div class="col-md-6">
                <label for="image-caption" class="form-label">Image Caption:</label>
                <input type="text" id="image-caption" name="imageCaption" class="form-control" required>
            </div>
            
            <div class="col-md-3">
                <label for="pet-age" class="form-label">Age (months):</label>
                <input type="number" id="pet-age" name="petAge" class="form-control" required>
            </div>
            
            <div class="col-md-3">
                <label for="location" class="form-label">Location:</label>
                <input type="text" id="location" name="location" class="form-control" required>
            </div>

            <div class="col-12 text-center">
                <button type="submit" class="btn btn-success px-4">Submit</button>
                <button type="reset" class="btn btn-secondary px-4">Clear</button>
            </div>
        </form>

        <?php include_once "includes/footer.inc"; ?>
    </div>
</body>
</html>
