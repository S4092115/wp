<?php include_once "includes/header.inc"; ?>
<?php include_once "includes/db_connect.inc"; ?>

<body>
        <main class="container py-4">
            <div class="text-center">
                <h1 class="display-4">PETS VICTORIA</h1>
                <p class="lead">WELCOME TO PET ADOPTION</p>
            </div>

            <!-- Bootstrap Carousel -->
            <div id="carouselExample" class="carousel slide mb-5" data-bs-ride="carousel">
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
                            echo '<img src="images/' . htmlspecialchars($row['image']) . '" class="d-block w-100 img-fluid" alt="Pet Image">';
                            echo '</div>';
                            $firstItem = false; // Set first item as active, rest won't be
                        }
                    } else {
                        // Fallback image if no pets are available
                        echo '<div class="carousel-item active">';
                        echo '<img src="images/default.jpg" class="d-block w-100 img-fluid" alt="No Image Available">';
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
            <div class="search-box mb-4">
                <form action="index.php" method="GET" class="row g-3">
                    <div class="col-md-5">
                        <input type="search" name="keyword" class="form-control" placeholder="I am looking for..." aria-label="Search">
                    </div>
                    <div class="col-md-4">
                        <select name="type" class="form-select" aria-label="Pet type">
                            <option value="">Select pet type</option>
                            <option value="Dog">Dog</option>
                            <option value="Cat">Cat</option>
                            <option value="Bird">Bird</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-outline-success w-100" type="submit">Search</button>
                    </div>
                </form>
            </div>

            <!-- Additional Info Section -->
            <div class="text-section text-center mt-5">
                <h2>Discover Pets Victoria</h2>
                <p>
                    Pets Victoria is a dedicated pet adoption organization based in Victoria, Australia, focused on
                    providing a safe and loving environment for pets in need. With a compassionate approach, Pets Victoria works tirelessly to rescue, rehabilitate, and rehome dogs, cats, and other animals.
                </p>
            </div>
        </main>

        <?php include_once "includes/footer.inc"; ?>
    </div>
</body>
</html>
