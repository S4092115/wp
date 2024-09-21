<?php include_once "includes/header.inc"; ?>

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
        <div>
            <h1>Pets Victoria</h1>
            <p>Welcome to Pet Adoption</p>
        </div>
        <img src="images/main.jpg" alt="Puppy and Kitten">
    </div>

    <?php include_once "includes/footer.inc"; ?>
    </div>
</body>

</html>