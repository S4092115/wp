<?php include_once "includes/header.inc"; ?>
<?php include_once "includes/db_connect.inc"; ?>

<body>
    <div class="wrapper">
        <header>
            <a href="index.php">
                <img src="images/logo.png" alt="Pets Victoria Logo" class="logo">
            </a>
            <?php include_once "includes/nav.inc"; ?>
        </header>

        <main class="main-content">
            <h1>Search for a Pet</h1>

            <!-- Search Form -->
            <form action="search.php" method="GET">
                <input type="text" name="keyword" placeholder="Enter keyword (e.g., name or description)" style="width: 300px; margin-right: 10px;">
                <select name="pettype">
                    <option value="" disabled selected>Select pet type</option>
                    <option value="Dog">Dog</option>
                    <option value="Cat">Cat</option>
                    <option value="Bird">Bird</option>
                    <option value="Other">Other</option>
                </select>
                <button type="submit" class="btn btn-success" style="margin-left: 10px;">Search</button>
            </form>

            <h2>Search Results</h2>

            <?php
            if (isset($_GET['keyword']) || isset($_GET['pettype'])) {
                $keyword = isset($_GET['keyword']) ? '%' . $_GET['keyword'] . '%' : '';
                $petType = isset($_GET['pettype']) ? $_GET['pettype'] : '';

                // Build the SQL query based on the search inputs
                $sql = "SELECT petid, petname, type, description, image FROM pets WHERE (1=1)";
                
                // Append conditions based on input
                if (!empty($keyword)) {
                    $sql .= " AND (petname LIKE ? OR description LIKE ?)";
                }
                if (!empty($petType)) {
                    $sql .= " AND type = ?";
                }

                // Prepare the SQL query
                $stmt = $conn->prepare($sql);

                // Bind parameters dynamically based on inputs
                if (!empty($keyword) && !empty($petType)) {
                    $stmt->bind_param("sss", $keyword, $keyword, $petType);
                } elseif (!empty($keyword)) {
                    $stmt->bind_param("ss", $keyword, $keyword);
                } elseif (!empty($petType)) {
                    $stmt->bind_param("s", $petType);
                }

                // Execute the query
                $stmt->execute();
                $result = $stmt->get_result();

                // Display the search results
                if ($result->num_rows > 0) {
                    echo '<div class="pets-container">';
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="pet-card">';
                        // Hyperlink to details.php using the petid
                        echo '<a href="details.php?petid=' . htmlspecialchars($row['petid']) . '">';
                        echo '<img src="images/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['petname']) . '" class="pet-image">';
                        echo '<h2>' . htmlspecialchars($row['petname']) . '</h2>';
                        echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                        echo '</a>';
                        echo '</div>';
                    }
                    echo '</div>';
                } else {
                    echo "<p>No pets found matching your search criteria.</p>";
                }

                $stmt->close();
            } else {
                echo "<p>Please enter a keyword or select a pet type to search.</p>";
            }
            ?>

        </main>

        <?php include_once "includes/footer.inc"; ?>
    </div>
</body>
</html>
