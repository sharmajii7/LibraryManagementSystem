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
    <h2> Add Category </h2>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
    <label> Category Name: </label>
    <input type="text" name="category" required />
    <br>
    <label> Status: </label>
    <label> <input type="radio" name="status" value="1" checked="checked"> Active </label>
    <label> <input type="radio" name="status" value="0"> Inactive </label>
    <br>
    <input type="submit" name="submit" value="Add"/>
</body>
</html>
<?php 
    include("components/database.php");
    if(isset($_POST["submit"])) {
        $category = $_POST["category"];
        $status = $_POST["status"];
        $uniquecategory = mysqli_query($conn, "SELECT * FROM category where categoryName = '$category';");
        if(mysqli_num_rows($uniquecategory) > 0) {
            echo "<script> alert('Category is already registered.') </script>";
        }
        else {
            try {
                mysqli_query($conn, "INSERT INTO category (categoryName, status) VALUES ('$category', '$status');");
            }
            catch (mysqli_sql_exception) {
                echo "<script> alert('Database error. Please try again later.'); </script>";
            }
            echo "<script> alert('Category added successfully.'); </script>";
        }
    }
    mysqli_close($conn);
?>