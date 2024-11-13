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
    <title>Library Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include("components/header.php"); ?>
    <div class="container mt-4">
        <h2>Update Author</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-3">
                <label class="form-label">Author Name:</label>
                <?php 
                    include("components/database.php");
                    $id = intval($_GET["authorid"]);
                    $records = mysqli_query($conn, "SELECT * FROM authors WHERE id = '$id';");
                    foreach($records as $record) {
                ?>
                <input type="text" name="author" value="<?php echo htmlspecialchars($record["authorName"]); ?>" class="form-control" required />
                <?php } mysqli_close($conn); ?>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
<?php 
    include("components/database.php");
    if(isset($_POST["update"])) {
        $id = intval($_GET["authorid"]);
        $author = $_POST["author"];
        try {
            mysqli_query($conn, "UPDATE authors SET authorName = '$author' WHERE id = '$id';");
            $_SESSION['message'] = "<div class='alert alert-success'>Author updated successfully.</div>";
        } catch (mysqli_sql_exception) {
            $_SESSION['message'] = "<div class='alert alert-danger'>Database error. Please try again later.</div>";
        }
        header("location: manageAuthor.php");
    }
    mysqli_close($conn);
?>
