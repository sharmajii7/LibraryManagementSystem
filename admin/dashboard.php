<?php 
    session_start();
    if(isset($_SESSION["alogin"]) == 0) header("Location: ../adminLogin.php");
    if(!empty($_SESSION['message'])) {
        echo '<div class="alert alert-info text-center">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include("components/header.php"); ?>
    
    <div class="container my-5">
        <h2 class="text-center mb-4">Admin Dashboard</h2>
        
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body text-center">
                        <h4 class="card-title">Books Listed</h4>
                        <p class="card-text">
                            <?php 
                                include("components/database.php");
                                $records1 = mysqli_query($conn, "SELECT * FROM books;");
                                echo mysqli_num_rows($records1);
                            ?>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body text-center">
                        <h4 class="card-title">Books Issued</h4>
                        <p class="card-text">
                            <?php 
                                $records2 = mysqli_query($conn, "SELECT * FROM issue;");
                                echo mysqli_num_rows($records2);
                            ?>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body text-center">
                        <h4 class="card-title">Books Returned</h4>
                        <p class="card-text">
                            <?php 
                                $records3 = mysqli_query($conn, "SELECT * FROM issue WHERE returnStatus = 1;");
                                echo mysqli_num_rows($records3);
                            ?>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body text-center">
                        <h4 class="card-title">Books Not Returned</h4>
                        <p class="card-text">
                            <?php 
                                echo (mysqli_num_rows($records2) - mysqli_num_rows($records3));
                            ?>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body text-center">
                        <h4 class="card-title">Registered Users</h4>
                        <p class="card-text">
                            <?php 
                                $records4 = mysqli_query($conn, "SELECT * FROM students;");
                                echo mysqli_num_rows($records4);
                            ?>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body text-center">
                        <h4 class="card-title">Authors Listed</h4>
                        <p class="card-text">
                            <?php 
                                $records5 = mysqli_query($conn, "SELECT * FROM authors;");
                                echo mysqli_num_rows($records5);
                            ?>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body text-center">
                        <h4 class="card-title">Categories Listed</h4>
                        <p class="card-text">
                            <?php 
                                $records6 = mysqli_query($conn, "SELECT * FROM category;");
                                echo mysqli_num_rows($records6);
                                mysqli_close($conn);
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
