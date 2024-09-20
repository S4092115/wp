<?php include_once "includes/header.inc"; ?>

<body>
    <header>
        <img src="images/logo.png" alt="Pets Victoria Logo" class="logo">
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

    <h1>Add a New Pet</h1>
    <form action="/submit-pet" method="POST" enctype="multipart/form-data">
        <label for="pet-name">Provide a name for the pet:</label>
        <input type="text" id="pet-name" name="petName" required>

        <label for="pet-type">Type:</label>
        <select id="pet-type" name="petType" required>
            <option value="" disabled selected>--Choose an option--</option>
        </select>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>

        <label for="image">Select an Image: <span style="color: red;">MAX IMAGE SIZE: 500PX</span></label>
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

    <footer>
        <p>&copy; Copyright S4092115. All Rights Reserved | Designed for Pets Victoria</p>
    </footer>
</body>

</html>