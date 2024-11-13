<?php if(isset($_SESSION['login'])) { ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <!-- Adjusted heading with larger font size -->
            <a class="navbar-brand" href="#" style="font-size: 28px; font-weight: bold; color: #007bff;">
                Library Management System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Account
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                            <li><a class="dropdown-item" href="changePass.php">Change Password</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="issuedBooks.php">Issued Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Log Out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<?php } else { ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <!-- Adjusted heading with larger font size -->
            <a class="navbar-brand" href="#" style="font-size: 28px; font-weight: bold; color: #007bff;">
                Library Management System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item" style="margin-right: 15px;">
                        <a class="nav-link" href="adminLogin.php"><b>Admin Login</b></a>
                    </li>
                    <li class="nav-item" style="margin-right: 15px;">
                        <a class="nav-link" href="register.php"><b>Student Register</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php"><b>Student Login</b></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<?php } ?>
