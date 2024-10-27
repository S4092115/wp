<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="pets.php">Pets</a></li>
        <li><a href="gallery.php">Gallery</a></li>
        <li><a href="search.php">Search</a></li>
        
        <!-- Only show 'Add Pet' and 'Profile' if the user is logged in -->
        <?php if (isset($_SESSION['username'])): ?>
            <li><a href="add.php">Add Pet</a></li>
            <!-- Ensure the userID is passed to the profile link -->
            <li><a href="user.php?userID=<?php echo $_SESSION['userID']; ?>">Profile</a></li>
        <?php endif; ?>

        <!-- Show Register and Login if the user is not logged in -->
        <?php if (!isset($_SESSION['username'])): ?>
            <li><a href="register.php">Register</a></li>
            <li><a href="login.php">Login</a></li>
        <?php else: ?>
            <li><a href="logout.php">Logout</a></li>
        <?php endif; ?>
    </ul>
</nav>
