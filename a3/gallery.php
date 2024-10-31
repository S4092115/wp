<?php include_once "includes/header.inc"; ?>
<?php include_once "includes/db_connect.inc"; ?>

<body>
    <div class="container-fluid px-0">
        <header class="text-white py-3">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-dark">
                    <a class="navbar-brand" href="index.php">
                        <img src="images/logo.png" alt="Pets Victoria Logo" class="logo img-fluid" style="height: 50px;">
                    </a>
                    <!-- Toggler for small screens -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <!-- Collapsible content -->
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <?php include_once "includes/nav.inc"; ?>
                    </div>
                </nav>
            </div>
        </header>

        <main class="container py-4">
            <div class="text-center mb-4">
                <h1 class="display-4">Pet Gallery</h1>
            </div>

            <div class="text-center mb-5">
                <h2>Pets Victoria has a lot to offer!</h2>
                <p>For almost two decades, Pets Victoria has helped create true social change by bringing pet adoption into
                    the mainstream. Our work has made a difference in the Victorian rescue community and for thousands of
                    pets in need of rescue and rehabilitation. Until every pet is safe, respected, and loved, we all still
                    have work to do.</p>
            </div>

            <div class="row">
                <?php
                $sql = "SELECT petid, petname, image FROM pets";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="col-sm-6 col-md-4 col-lg-3 mb-4">';
                        echo '<div class="card h-100 shadow-sm">';
                        // Ensure you're passing `petid` as the parameter in the URL, as `details.php` expects `petid`
                        echo '<a href="details.php?petid=' . $row['petid'] . '" class="text-decoration-none text-dark">';
                        echo '<img src="images/' . htmlspecialchars($row['image']) . '" class="card-img-top img-fluid" alt="' . htmlspecialchars($row['petname']) . '">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . htmlspecialchars($row['petname']) . '</h5>';
                        echo '</div>';
                        echo '</a>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "<p class='text-center'>No pets available in the gallery at the moment.</p>";
                }
                ?>
            </div>
        </main>

        <?php include_once "includes/footer.inc"; ?>
    </div>
</body>
</html>
