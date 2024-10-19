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

            <!-- Carousel -->
            <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    $sql = "SELECT image FROM pets ORDER BY petid DESC LIMIT 4";
                    $result = $conn->query($sql);
                    $active = true; // First item should be active
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Ensure only the first item gets the "active" class
                            echo '<div class="carousel-item ' . ($active ? 'active' : '') . '">';
                            echo '<img src="images/' . $row['image'] . '" class="d-block w-100 carousel-img" alt="Pet Image" style="max-height: 400px;">';
                            echo '</div>';
                            $active = false; // Remove the "active" class for subsequent items
                        }
                    } else {
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
                <input class="form-control me-2" type="search" placeholder="I am looking for..." aria-label="Search" style="display: inline-block; width: 250px; margin-right: 10px;">
                <input class="form-control me-2" type="text" placeholder="Select your pet type" aria-label="Pet type" style="display: inline-block; width: 250px;">
                <button class="btn btn-outline-success" type="submit" style="margin-left: 10px;">Search</button>
            </div>

            <div class="text-section" style="margin-top: 40px;">
                <h1>Discover Pets Victoria</h1>
                <p>
                    Pets Victoria is a dedicated pet adoption organization based in Victoria, Australia, focused on
                    providing a safe and loving environment for pets in need. With a compassionate approach, Pets Victoria works tirelessly to rescue, rehabilitate, and rehome dogs, cats, and other animals.
                </p>
            </div>
        </main>

        <?php include_once "includes/footer.inc"; ?>
    </div>
    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
