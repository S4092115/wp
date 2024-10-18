<?php include_once "includes/header.inc"; ?>
<?php include_once "includes/db_connect.inc"; ?>

<body>
    <div class="wrapper">
        <header>
            <a href="index.php">
                <img src="images/logo.png" alt="Pets Victoria Logo" class="logo">
            </a>
            <!-- Include the navigation from nav.inc -->
            <?php include_once "includes/nav.inc"; ?>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </header>

        <main class="main-content">
            <div>
                <h1>Pets Victoria</h1>
                <p>Welcome to Pet Adoption</p>
            </div>
            <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    // Fetch the last four images from the pets table for the carousel
                    $sql = "SELECT image FROM pets ORDER BY petid DESC LIMIT 4";
                    $result = $conn->query($sql);
                    $active = "active"; // Set the first item to active
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="carousel-item ' . $active . '">';
                        echo '<img src="images/' . $row['image'] . '" class="d-block w-100" alt="...">';
                        echo '</div>';
                        $active = ""; // Reset active for subsequent items
                    }
                    ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

            <img src="images/main.jpg" alt="Puppy and Kitten" class="img-fluid mt-4">
        </main>

        <?php include_once "includes/footer.inc"; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
