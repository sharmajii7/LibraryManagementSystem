<!-- Horizontal Navbar at the top -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php" style="font-size: 24px; font-weight: bold; color: #007bff;">
            Admin Dashboard
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <!-- Categories Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categories
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
                        <li><a class="dropdown-item" href="addCategory.php">Add Category</a></li>
                        <li><a class="dropdown-item" href="manageCategory.php">Manage Category</a></li>
                    </ul>
                </li>
                <!-- Authors Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="authorsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Authors
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="authorsDropdown">
                        <li><a class="dropdown-item" href="addAuthor.php">Add Author</a></li>
                        <li><a class="dropdown-item" href="manageAuthor.php">Manage Authors</a></li>
                    </ul>
                </li>
                <!-- Books Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="booksDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Books
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="booksDropdown">
                        <li><a class="dropdown-item" href="addBook.php">Add Book</a></li>
                        <li><a class="dropdown-item" href="manageBook.php">Manage Books</a></li>
                    </ul>
                </li>
                <!-- Issue Books Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="issueBooksDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Issue Books
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="issueBooksDropdown">
                        <li><a class="dropdown-item" href="issueBook.php">Issue New Book</a></li>
                        <li><a class="dropdown-item" href="manageIssueBook.php">Manage Issued Books</a></li>
                    </ul>
                </li>
                <!-- Manage Students -->
                <li class="nav-item">
                    <a class="nav-link" href="manageStudent.php">Manage Students</a>
                </li>
                <!-- Change Password -->
                <li class="nav-item">
                    <a class="nav-link" href="changePass.php">Change Password</a>
                </li>
                <!-- Log out -->
                <li class="nav-item">
                    <a class="nav-link text-danger" href="logout.php">Log out</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

