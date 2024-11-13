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
    <div class="container mt-5">
        <h2 class="mb-4"> Add Category </h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form-group">
            <div class="mb-3">
                <label for="category" class="form-label">Category Name:</label>
                <input type="text" name="category" id="category" class="form-control" required />
            </div>
            <div class="mb-3">
                <label class="form-label">Status:</label><br>
                <label class="form-check-label me-3">
                    <input type="radio" name="status" value="1" class="form-check-input" checked> Active
                </label>
                <label class="form-check-label">
                    <input type="radio" name="status" value="0" class="form-check-input"> Inactive
                </label>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Add</button>
        </form>
    </div>
</body>
</html>
<?php 
    include("components/database.php");
    if(isset($_POST["submit"])) {
        $category = $_POST["category"];
        $status = $_POST["status"];
        $uniquecategory = mysqli_query($conn, "SELECT * FROM category WHERE categoryName = '$category';");
        if(mysqli_num_rows($uniquecategory) > 0) {
            echo "<script> alert('Category is already registered.') </script>";
        }
        else {
            try {
                mysqli_query($conn, "INSERT INTO category (categoryName, status) VALUES ('$category', '$status');");
                echo "<script> alert('Category added successfully.'); </script>";
            }
            catch (mysqli_sql_exception) {
                echo "<script> alert('Database error. Please try again later.'); </script>";
            }
        }
    }
    mysqli_close($conn);
?>
