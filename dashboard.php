<?php 
    session_start();
    if(isset($_SESSION["alogin"])) header("Location: admin/dashboard.php");
    if(isset($_SESSION["login"]) == 0) header("Location: index.php");
    if(!empty($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include("components/header.php"); ?>
    
    <div class="container mt-4">
        <h2 class="text-center mb-4">Dashboard</h2>
        
        <!-- Books Issued -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4>Books Issued:</h4>
            </div>
            <div class="card-body">
                <?php 
                    include("components/database.php");
                    $email = $_SESSION["login"];
                    $records1 = mysqli_query($conn, "SELECT * FROM issue, students WHERE issue.studentID = students.studentID AND students.email = '$email';");
                    echo '<h5>' . mysqli_num_rows($records1) . '</h5>';
                ?>
            </div>
        </div>
        
        <!-- Books Not Returned -->
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h4>Books Not Returned:</h4>
            </div>
            <div class="card-body">
                <?php
                    $records2 = mysqli_query($conn, "SELECT * FROM issue, students WHERE issue.studentID = students.studentID AND students.email = '$email' AND issue.returnStatus = 0;");
                    echo '<h5>' . mysqli_num_rows($records2) . '</h5>';
                    mysqli_close($conn);
                ?>
            </div>
        </div>
    </div>

</body>
</html>
