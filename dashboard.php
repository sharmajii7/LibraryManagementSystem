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
    <title> Library Management System </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include("components/header.php"); ?>
    <h2> Dashboard </h2>
    <h4> Books Issued: </h4>
    <?php 
        include("components/database.php");
        $email = $_SESSION["login"];
        $records1 = mysqli_query($conn, "SELECT * FROM issue, students WHERE issue.studentID = students.studentID AND students.email = '$email';");
        echo mysqli_num_rows($records1);
    ?>
    <h4> Books Not Returned: </h4>
    <?php
        $records2 = mysqli_query($conn, "SELECT * FROM issue, students WHERE issue.studentID = students.studentID AND students.email = '$email' AND issue.returnStatus = 0;");
        echo mysqli_num_rows($records2);
        mysqli_close($conn);
    ?>
</body>
</html>