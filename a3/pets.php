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
            <div class="text-section">
                <h1>Discover Pets Victoria</h1>
                <p>Pets Victoria is a dedicated pet adoption organization based in Victoria, Australia, focused on providing
                    a safe and loving environment for pets in need. With a compassionate approach, Pets Victoria works
                    tirelessly to rescue, rehabilitate, and rehome dogs, cats, and other animals. Their mission is to
                    connect these deserving pets with caring individuals and families, creating lifelong bonds.</p>
            </div>

            <div class="content-wrapper">
                <img src="images/pets.jpeg" alt="Pets running around" class="pets-image">
                <table class="pets-table">
                    <thead>
                        <tr>
                            <th>Pet</th>
                            <th>Type</th>
                            <th>Age</th>
                            <th>Location</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    // Query to get all pets from the database
                    $sql = "SELECT petid, petname, type, age, location FROM pets";
                    $result = $conn->query($sql);

                    //This will check for query errors and report them 
                    if (!$result) {
                        echo "Error: " . $conn->error;
                    } else {
                        if ($result->num_rows > 0) {
                            // Loop through each pet in the database and display it in the table
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                // Hyperlink petname to details.php using the petid in the query string
                                echo "<td><a href='details.php?id=" . $row['petid'] . "'>" . $row['petname'] . "</a></td>";
                                echo "<td>" . $row['type'] . "</td>";
                                echo "<td>" . ($row['age'] < 12 ? $row['age'] . " months" : round($row['age'] / 12, 1) . " years") . "</td>";
                                echo "<td>" . $row['location'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No pets available at the moment.</td></tr>";
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php include_once "includes/footer.inc"; ?>
    </div>
</body>
</html>
