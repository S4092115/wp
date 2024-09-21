<?php include_once "includes/header.inc"; ?>

<body>
    <header>
        <a href="index.php">
        <img src="images/logo.png" alt="Pets Victoria Logo" class="logo">
        </a>
        <?php include_once "includes/nav.inc"; ?>
        <input type="search" placeholder="Search">
        <img src="images/searchico.png" alt="Search Icon" class="search-icon">
    </header>
    <div class="main-content">
        <div class="text-section">
            <h1>Discover Pets Victoria</h1>
            <p>Pets Victoria is a dedicated pet adoption organization based in Victoria, Australia, focused on providing
                a safe and loving environment for pets in need. With a compassionate approach, Pets Victoria works
                tirelessly to rescue, rehabilitate, and rehome dogs, cats, and other animals. Their mission is to
                connect these deserving pets with caring individuals and families, creating lifelong bonds. The
                organization offers a range of services, including adoption counseling, pet education, and community
                support programs, all aimed at promoting responsible pet ownership and reducing the number of homeless
                animals.</p>
        </div>
        <div class="content-wrapper">
            <img src="images/pets.jpeg" alt="Pets running around" class="pets-image">
            <table>
                <tr>
                    <th>Pet</th>
                    <th>Type</th>
                    <th>Age</th>
                    <th>Location</th>
                </tr>
                <tr>
                    <td>Milo</td>
                    <td>Cat</td>
                    <td>3 months</td>
                    <td>Melbourne CBD</td>
                </tr>
                <tr>
                    <td>Baxter</td>
                    <td>Dog</td>
                    <td>5 months</td>
                    <td>Cape Woolamai</td>
                </tr>
                <tr>
                    <td>Luna</td>
                    <td>Cat</td>
                    <td>1 month</td>
                    <td>Ferntree Gully</td>
                </tr>
                <tr>
                    <td>Willow</td>
                    <td>Dog</td>
                    <td>48 months</td>
                    <td>Marysville</td>
                </tr>
                <tr>
                    <td>Oliver</td>
                    <td>Dog</td>
                    <td>12 months</td>
                    <td>Grampians</td>
                </tr>
                <tr>
                    <td>Bella</td>
                    <td>Dog</td>
                    <td>10 months</td>
                    <td>Carlton</td>
                </tr>
            </table>
        </div>
    </div>
    <?php include_once "includes/footer.inc"; ?>
</body>

</html>