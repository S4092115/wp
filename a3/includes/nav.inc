<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="pets.php">Pets</a></li>
        <li><a href="gallery.php">Gallery</a></li>
        <li><a href="search.php">Search</a></li>
        
        <!-- Only show 'Add Pet' if the user is logged in -->
        <?php if (isset($_SESSION['username'])): ?>
            <li><a href="add.php">Add Pet</a></li>
            <li><a href="user.php">Profile</a></li>

        <?php endif; ?>

        <!-- Show Register and Login options if the user is not logged in -->
        <?php if (!isset($_SESSION['username'])): ?>
            <li><a href="register.php">Register</a></li>
            <li><a href="login.php">Login</a></li>
        <?php else: ?>
            <!-- If the user is logged in, show 'Logout' instead -->
            <li><a href="logout.php">Logout</a></li>
        <?php endif; ?>
    </ul>
</nav>
