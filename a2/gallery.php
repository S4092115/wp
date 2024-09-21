<?php include_once "includes/header.inc"; ?>

<body>
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
        <h1>Pet Gallery</h1>
    </div>
    <div class="text-section">
        <h1>Pets Victoria has a lot to offer!</h1>
        <p>For almost two decades, Pets Victoria has helped in creating true social change by bringing pet adoption into
            the mainstream. Our work has helped make a difference to the Victorian rescue community and thousands of
            pets in need of rescue and rehabilitation. But, until every pet is safe, respected, and loved, we all still
            have big, hairy work to do.</p>
        <div class="pets-container">
            <div class="pet-card">
                <img src="images/cat1.jpeg" alt="Milo">
                <h2>Milo</h2>
            </div>
            <div class="pet-card">
                <img src="images/dog1.jpeg" alt="Baxter">
                <h2>Baxter</h2>
            </div>
            <div class="pet-card">
                <img src="images/cat2.jpeg" alt="Luna">
                <h2>Luna</h2>
            </div>
            <div class="pet-card">
                <img src="images/dog2.jpeg" alt="Willow">
                <h2>Willow</h2>
            </div>
            <div class="pet-card">
                <img src="images/cat3.jpeg" alt="Oliver">
                <h2>Oliver</h2>
            </div>
            <div class="pet-card">
                <img src="images/dog3.jpeg" alt="Bella">
                <h2>Bella</h2>
            </div>
        </div>
    </div>
    <footer>
        <p>&copy; Copyright S4092115. All Rights Reserved | Designed for Pets Victoria</p>
    </footer>
</body>

</html>