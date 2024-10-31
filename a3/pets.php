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
            <div class="text-center mb-5">
                <h1 class="display-4">Discover Pets Victoria</h1>
                <p class="lead">Pets Victoria is a dedicated pet adoption organization based in Victoria, Australia, focused on
                    providing a safe and loving environment for pets in need. With a compassionate approach, Pets Victoria works
                    tirelessly to rescue, rehabilitate, and rehome dogs, cats, and other animals. Their mission is to
                    connect these deserving pets with caring individuals and families, creating lifelong bonds.</p>
            </div>

            <div class="row mb-5">
                <div class="col-12 text-center">
                    <img src="images/pets.jpeg" alt="Pets running around" class="img-fluid rounded">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped align-middle">
                    <thead class="table-primary">
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
                        echo "<tr><td colspan='4'>Error: " . $conn->error . "</td></tr>";
                    } else {
                        if ($result->num_rows > 0) {
                            // Loop through each pet in the database and display it in the table
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                // Hyperlink petname to details.php using the petid in the query string
                                echo "<td><a href='details.php?petid=" . $row['petid'] . "' class='text-decoration-none text-primary'>" . $row['petname'] . "</a></td>";
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
        </main>

        <?php include_once "includes/footer.inc"; ?>
    </div>
</body>
</html>
