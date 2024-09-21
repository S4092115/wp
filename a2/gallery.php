<?php include_once "includes/header.inc"; ?>
<?php include_once "includes/db_connect.inc"; ?>

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
            <h1>Pet Gallery</h1>
        </div>
        <div class="text-section">
            <h1>Pets Victoria has a lot to offer!</h1>
            <p>For almost two decades, Pets Victoria has helped in creating true social change by bringing pet adoption into
                the mainstream. Our work has helped make a difference to the Victorian rescue community and thousands of
                pets in need of rescue and rehabilitation. But, until every pet is safe, respected, and loved, we all still
                have big, hairy work to do.</p>

            <div class="pets-container">
                <?php
                //Finish this tommrrow or later
                $sql = "SELECT petid, petname, image FROM pets";
                $result = $conn->query($sql);

                // check the results 
                if ($result && $result->num_rows > 0) {
                    // display the pet
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="pet-card">';
  
                    }
                } else {
                    echo "<p>No pets available in the gallery at the moment.</p>";
                }
                ?>
            </div>
        </div>
        <?php include_once "includes/footer.inc"; ?>
    </div>
</body>

</html>
