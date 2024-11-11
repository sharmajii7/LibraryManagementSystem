<?php 
    session_start();
    if(isset($_SESSION["alogin"]) == 0) header("Location: ../adminLogin.php");
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
    <title> Library Management System </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include("components/header.php"); ?>
    <h2> Admin Dashboard </h2>
    <h4> Books Listed: </h4>
    <?php 
        include("components/database.php");
        $records1 = mysqli_query($conn, "SELECT * FROM books;");
        echo mysqli_num_rows($records1);
    ?>
    <h4> Books Issued: </h4>
    <?php 
        $records2 = mysqli_query($conn, "SELECT * FROM issue;");
        echo mysqli_num_rows($records2);
    ?>
    <h4> Books Returned: </h4>
    <?php 
        $records3 = mysqli_query($conn, "SELECT * FROM issue WHERE returnStatus = 1;");
        echo mysqli_num_rows($records3);
    ?>
    <h4> Books Not Returned: </h4>
    <?php 
        echo (mysqli_num_rows($records2) - mysqli_num_rows($records3));
    ?>
    <h4> Registered Users: </h4>
    <?php 
        $records4 = mysqli_query($conn, "SELECT * FROM students;");
        echo mysqli_num_rows($records4);
    ?>
    <h4> Authors Listed: </h4>
    <?php 
        $records5 = mysqli_query($conn, "SELECT * FROM authors;");
        echo mysqli_num_rows($records5);
    ?>
    <h4> Categories Listed: </h4>
    <?php 
        $records6 = mysqli_query($conn, "SELECT * FROM category;");
        echo mysqli_num_rows($records6);
        mysqli_close($conn);
    ?>
</body>
</html>