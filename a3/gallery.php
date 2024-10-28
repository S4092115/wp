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
                $sql = "SELECT petid, petname, image FROM pets";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="pet-card">';
                        // Ensure you're passing `petid` as the parameter in the URL, as `details.php` expects `petid`
                        echo '<a href="details.php?petid=' . $row['petid'] . '">';
                        echo '<img src="images/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['petname']) . '">';
                        echo '<h2>' . htmlspecialchars($row['petname']) . '</h2>';
                        echo '</a>';
                        echo '</div>';
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
