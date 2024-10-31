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
    $username = $_SESSION['username']; // Get the logged-in user's username

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

                // Inserts the pet details along with the username
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
        <h1>Add a New Pet</h1>
        <form action="add.php" method="POST" enctype="multipart/form-data">
            <label for="pet-name">Provide a name for the pet:</label>
            <input type="text" id="pet-name" name="petName" required>

            <label for="pet-type">Type:</label>
            <select id="pet-type" name="petType" required>
                <option value="" disabled selected>--Choose an option--</option>
                <option value="Dog">Dog</option>
                <option value="Cat">Cat</option>
                <option value="Bird">Bird</option>
                <option value="Other">Other</option>
            </select>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="image">Select an Image: <span style="color: red;">MAX IMAGE SIZE: 500KB</span></label>
            <input type="file" id="image" name="image" required>

            <label for="image-caption">Image Caption:</label>
            <input type="text" id="image-caption" name="imageCaption" required>

            <label for="pet-age">Age (months):</label>
            <input type="number" id="pet-age" name="petAge" required>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>

            <input type="submit" value="Submit">
            <button type="reset">Clear</button>
        </form>

        <?php include_once "includes/footer.inc"; ?>
    </div>
</body>
</html>
