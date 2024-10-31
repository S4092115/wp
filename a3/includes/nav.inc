<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #108484;">
        <a class="navbar-brand" href="index.php">
        </a>
        </button>
        
        <!-- Navbar links -->
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link text-uppercase" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link text-uppercase" href="pets.php">Pets</a></li>
                <li class="nav-item"><a class="nav-link text-uppercase" href="gallery.php">Gallery</a></li>
                <li class="nav-item"><a class="nav-link text-uppercase" href="search.php">Search</a></li>
                
                <!-- Only show 'Add Pet' and 'Profile' if the user is logged in -->
                <?php if (isset($_SESSION['username'])): ?>
                    <li class="nav-item"><a class="nav-link text-uppercase" href="add.php">Add Pet</a></li>
                    <li class="nav-item"><a class="nav-link text-uppercase" href="user.php?userID=<?php echo $_SESSION['userID']; ?>">Profile</a></li>
                    <li class="nav-item"><a class="nav-link text-uppercase" href="logout.php">Logout</a></li>
                <?php else: ?>
                    <!-- Show Register and Login if the user is not logged in -->
                    <li class="nav-item"><a class="nav-link text-uppercase" href="register.php">Register</a></li>
                    <li class="nav-item"><a class="nav-link text-uppercase" href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
