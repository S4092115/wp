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
            <h1>PETS VICTORIA</h1>
            <h2>WELCOME TO PET ADOPTION</h2>

            <!-- Bootstrap Carousel -->
            <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    // SQL query to select images from the pets table
                    $sql = "SELECT image FROM pets ORDER BY petid DESC LIMIT 4";
                    $result = $conn->query($sql);
                    $firstItem = true; // Track the first item to make it active

                    if ($result->num_rows > 0) {
                        // Fetch and display each image
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="carousel-item ' . ($firstItem ? 'active' : '') . '">';
                            echo '<img src="images/' . htmlspecialchars($row['image']) . '" class="d-block w-100 carousel-img" alt="Pet Image" style="max-height: 400px;">';
                            echo '</div>';
                            $firstItem = false; // Set first item as active, rest won't be
                        }
                    } else {
                        // Fallback image if no pets are available
                        echo '<div class="carousel-item active">';
                        echo '<img src="images/default.jpg" class="d-block w-100" alt="No Image Available" style="max-height: 400px;">';
                        echo '</div>';
                    }
                    ?>
                </div>

                <!-- Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

            <!-- Search Bar -->
            <div class="search-box" style="margin-top: 20px;">
                <form action="index.php" method="GET">
                    <input class="form-control me-2" type="search" name="keyword" placeholder="I am looking for..." aria-label="Search" style="display: inline-block; width: 250px; margin-right: 10px;">
                    <select class="form-control me-2" name="type" aria-label="Pet type" style="display: inline-block; width: 250px;">
                        <option value="">Select pet type</option>
                        <option value="Dog">Dog</option>
                        <option value="Cat">Cat</option>
                        <option value="Bird">Bird</option>
                        <option value="Other">Other</option>
                    </select>
                    <button class="btn btn-outline-success" type="submit" style="margin-left: 10px;">Search</button>
                </form>
            </div>

            <!-- Search Results Section -->
            <?php
            // Handle search functionality based on GET parameters
            if ($_SERVER['REQUEST_METHOD'] === 'GET' && (isset($_GET['keyword']) || isset($_GET['type']))) {
                $searchKeyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
                $searchType = isset($_GET['type']) ? trim($_GET['type']) : '';

                // SQL base query
                $sql = "SELECT petid, petname, image, description, type FROM pets WHERE 1=1";

                // Add conditions based on user inputs
                if (!empty($searchKeyword)) {
                    $sql .= " AND (petname LIKE ? OR description LIKE ?)";
                }
                if (!empty($searchType)) {
                    $sql .= " AND type = ?";
                }

                // Prepare the SQL statement
                $stmt = $conn->prepare($sql);

                // Bind parameters based on search inputs
                if (!empty($searchKeyword) && !empty($searchType)) {
                    $keyword = '%' . $searchKeyword . '%';
                    $stmt->bind_param('sss', $keyword, $keyword, $searchType);
                } elseif (!empty($searchKeyword)) {
                    $keyword = '%' . $searchKeyword . '%';
                    $stmt->bind_param('ss', $keyword, $keyword);
                } elseif (!empty($searchType)) {
                    $stmt->bind_param('s', $searchType);
                }

                // Execute the query
                $stmt->execute();
                $result = $stmt->get_result();

                // Display search results
                if ($result->num_rows > 0) {
                    echo '<div class="pets-container" style="margin-top: 40px;">';
                    while ($row = $result->fetch_assoc()) {
                        // Display each pet's details and link to its page
                        echo '<a href="details.php?petid=' . htmlspecialchars($row['petid']) . '" class="pet-link">';
                        echo '<div class="pet-card">';
                        echo '<img src="images/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['petname']) . '">';
                        echo '<h2>' . htmlspecialchars($row['petname']) . '</h2>';
                        echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                        echo '</div>';
                        echo '</a>';
                    }
                    echo '</div>';
                } else {
                    echo "<p>No pets found for your search criteria.</p>";
                }

                // Close the statement
                $stmt->close();
            }
            ?>

            <!-- Additional Info Section -->
            <div class="text-section" style="margin-top: 40px;">
                <h1>Discover Pets Victoria</h1>
                <p>
                    Pets Victoria is a dedicated pet adoption organization based in Victoria, Australia, focused on
                    providing a safe and loving environment for pets in need. With a compassionate approach, Pets Victoria works tirelessly to rescue, rehabilitate, and rehome dogs, cats, and other animals.
                </p>
            </div>
        </main>

        <?php include_once "includes/footer.inc"; ?>
</body>
</html>
