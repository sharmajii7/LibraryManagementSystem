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
    <h2> Update Category </h2>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
    <label> Category Name: </label>
    <?php 
        include("components/database.php");
        $id = intval($_GET["categoryid"]);
        $records = mysqli_query($conn, "SELECT * FROM category WHERE id = '$id';");
        foreach($records as $record) {
    ?>
    <input type="text" name="category" value="<?php echo $record["categoryName"]; ?>" required />
    <br>
    <?php if($record["status"]) { ?>
    <label> Status: </label>
    <label> <input type="radio" name="status" value="1" checked="checked"> Active </label>
    <label> <input type="radio" name="status" value="0"> Inactive </label>
    <?php } else { ?>
    <label> Status: </label>
    <label> <input type="radio" name="status" value="1"> Active </label>
    <label> <input type="radio" name="status" value="0" checked="checked"> Inactive </label>
    <?php }} mysqli_close($conn); ?>
    <br>
    <input type="submit" name="update" value="Update"/>
</body>
</html>
<?php 
    include("components/database.php");
    if(isset($_POST["update"])) {
        $id = intval($_GET["categoryid"]);
        $category = $_POST["category"];
        $status = $_POST["status"];
        try {
            mysqli_query($conn, "UPDATE category SET categoryName = '$category', status = '$status' WHERE id = '$id';");
        }
        catch (mysqli_sql_exception) {
            echo "<script> alert('Database error. Please try again later.'); </script>";
        }
        $_SESSION['message'] = "<script> alert('Category updated successfully.'); </script>";
        header("location: manageCategory.php");
    }
    mysqli_close($conn);
?>